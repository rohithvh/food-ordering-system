from fastmcp import FastMCP
import boto3
import os
import requests
server = FastMCP("simple-mcp-server")

@server.tool()
def list_aws_resources(resource_type_name: str, region: str = "us-east-1") -> dict:
    """
    Prompts:
    - List all resources of a given AWS resource type.
    - Show me all <resource_type_name> resources.

    Description:
    Uses AWS CloudControl API to list resources of the specified type.
    """
    try:
        client = boto3.client("cloudcontrol", region_name=region)
        paginator = client.get_paginator("list_resources")
        resources = []
        for page in paginator.paginate(TypeName=resource_type_name):
            resources.extend(page.get("ResourceDescriptions", []))
        return {"resources": resources}
    except Exception as e:
        return {"error": str(e)}

@server.tool()
def get_aws_resource_details(resource_type_name: str, identifier: str, region: str = "us-east-1") -> dict:
    """
    Prompts:
    - Get details of a specific AWS resource.
    - Show me details for <identifier> of type <resource_type_name>.

    Description:
    Uses AWS CloudControl API to get details of a specific resource.
    """
    try:
        client = boto3.client("cloudcontrol", region_name=region)
        response = client.get_resource(TypeName=resource_type_name, Identifier=identifier)
        return response.get("ResourceDescription", {})
    except Exception as e:
        return {"error": str(e)}
    

### TFE mcp server
@server.tool()
def get_terraform_cloud_module(module_name: str, organization: str, provider: str = "aws") -> list:
    """
    Prompts:
    - Get details of a Terraform module published in Terraform Cloud.
    - Show metadata for <module_name> in <organization>.

    Description:
    Fetches details about a Terraform module published in Terraform Cloud using the Terraform Cloud API.
    """
    tfe_token = os.getenv("TF_TOKEN_app_terraform_io")  # Read token from environment variable
    if not tfe_token:
        return {"error": "TFE_TOKEN environment variable not set."}
    headers = {
        "Authorization": f"Bearer {tfe_token}",
        "Content-Type": "application/vnd.api+json"
    }
    #url = f"https://app.terraform.io/api/v2/organizations/{organization}/registry-modules/private/{organization}/{module_name}/{provider}"
    #url = f"https://app.terraform.io/api/registry/v1/modules/{organization}/{module_name}/{provider}/versions"
    #url= f"https://app.terraform.io/api/registry/v1/modules/Rohith_Demo/s3_bucket/aws/versions"
    url = f"https://app.terraform.io/api/v2/organizations/{organization}/registry-modules"
    try:
        response = requests.get(url, headers=headers)
        if response.status_code == 200:
            data = response.json()
            modules = data.get("data", [])
            for module in modules:
                attrs = module.get("attributes", {})
                if attrs.get("name") == module_name and attrs.get("provider") == provider:
                    # return {
                    #     "name": attrs.get("name"),
                    #     "provider": attrs.get("provider"),
                    #     "source": attrs.get("source"),
                    #     "description": attrs.get("description"),
                    #     "versions": attrs.get("versions")
                    # }
                     return module
            return {"error": f"Module '{module_name}' with provider '{provider}' not found in organization '{organization}'."}
        else:
            return {"error": f"Failed to fetch module: {response.status_code} {response.text}"}
    except Exception as e:
        return {"error": str(e)}


### GitHub mcp server
@server.tool()   
def list_github_repositories(user_or_org: str) -> list:
    """
    Prompts:
    - List all repositories for a GitHub user or organization.
    - Show me all repos for <user_or_org>.

    Description:
    Returns a list of repository names for the specified GitHub user or organization.
    """
    github_token = os.getenv("GITHUB_TOKEN")  # Read token from environment variable
    if not github_token:
        return {"error": "GITHUB_TOKEN environment variable not set."}
    headers = {
        "Authorization": f"Bearer {github_token}",
        "Content-Type": "application/vnd.api+json"
    }
    #print(github_token)
    url = f"https://api.github.com/users/{user_or_org}/repos"
    try:
        response = requests.get(url, headers=headers)
        if response.status_code == 200:
            repos = response.json()
            return [repo for repo in repos]
        else:
            return {"error": f"Failed to fetch repositories: {response.status_code} {response.text}"}
    except Exception as e:
        return {"error": str(e)}


@server.tool()
def get_github_root_contents(repo: str, ref: str = "main") -> dict:
    """
    Prompts:
    - Get all root-level contents for a specific commit or branch in a GitHub repo.
    - List files and folders at the root of <repo> for <ref>.

    Description:
    Fetches the list of files and directories at the root of a GitHub repository for a given branch or commit.
    Returns all parameters for each item.
    """
    github_token = os.getenv("GITHUB_TOKEN")  # Read token from environment variable
    if not github_token:
        return {"error": "GITHUB_TOKEN environment variable not set."}
    headers = {
        "Authorization": f"Bearer {github_token}",
        "Content-Type": "application/vnd.api+json"
    }
    #print(github_token)
    url = f"https://api.github.com/repos/{repo}/contents/?ref={ref}"
    try:
        response = requests.get(url, headers=headers)
        if response.status_code == 200:
            items = response.json()
            # Return all parameters for each item
            return { "items": items }
        else:
            return {"error": f"Failed to fetch contents: {response.status_code} {response.text}"}
    except Exception as e:
        return {"error": str(e)}

if __name__ == '__main__':
    server.run(transport="http", host="127.0.0.1", port=8080, path="/mcp")
