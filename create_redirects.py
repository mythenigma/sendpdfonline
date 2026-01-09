#!/usr/bin/env python3
"""
Create redirect HTML files for broken URLs with incorrect paths
"""

import os
from pathlib import Path

# Map of incorrect URLs to correct URLs
REDIRECTS = {
    # Path errors with usecase/usecase/
    "usecase/usecase/article/limit-pdf-open-times.html": "https://sendpdfonline.com/article/limit-pdf-open-times.html",
    "usecase/usecase/features/shareeasily.html": "https://sendpdfonline.com/features/en/sharing/shareeasily.html",
    "usecase/usecase/usecase/secure-pdf-sharing.html": "https://sendpdfonline.com/usecase/secure-pdf-sharing.html",
    "usecase/usecase/features/free-pdf-hosting-and-sharing.html": "https://sendpdfonline.com/features/en/hosting/free-pdf-hosting-and-sharing.html",
    "usecase/usecase/features/email-verification-secure-pdf-access.html": "https://sendpdfonline.com/features/en/security/email-verification-secure-pdf-access.html",
    "usecase/usecase/features/google-drive-vs-maipdf.html": "https://sendpdfonline.com/features/en/comparison/google-drive-vs-maipdf.html",
    "usecase/usecase/features/how-to-share-pdf-online.html": "https://sendpdfonline.com/features/en/sharing/how-to-share-pdf-online.html",
    "usecase/usecase/features/encrypt-pdf-prevent-editing-cn.html": "https://sendpdfonline.com/features/zh/security/encrypt-pdf-prevent-editing-cn.html",
    "usecase/usecase/features/sharepdf.html": "https://sendpdfonline.com/features/en/sharing/sharepdf.html",
    "usecase/usecase/article/index.html": "https://sendpdfonline.com/article/",
    
    # Path errors with usecase/features/
    "usecase/features/features/share-pdf-files-online.html": "https://sendpdfonline.com/features/en/sharing/share-pdf-files-online.html",
    "usecase/features/features/how-to-share-pdf-online.html": "https://sendpdfonline.com/features/en/sharing/how-to-share-pdf-online.html",
    
    # Path errors with features/usecase/
    "features/usecase/pdf-branding.html": "https://sendpdfonline.com/usecase/pdf-branding.html",
    "features/usecase/usecase/german/passwortschutz.html": "https://sendpdfonline.com/german/passwortschutz.html",
    
    # Path errors with japanese/
    "japanese/features/design-file-organization.html": "https://sendpdfonline.com/features/en/design/design-file-organization.html",
    "japanese/features/features/designer-portfolio-pdf.html": "https://sendpdfonline.com/features/en/design/designer-portfolio-pdf.html",
    "japanese/japanese/usecase/secure-pdf-sharing.html": "https://sendpdfonline.com/usecase/secure-pdf-sharing.html",
    "japanese/features/maipdf-secure-pdf-hosting-cn.html": "https://sendpdfonline.com/features/zh/security/maipdf-secure-pdf-hosting-cn.html",
    "usecase/japanese/features/design-project-collaboration.html": "https://sendpdfonline.com/features/en/design/design-project-collaboration.html",
    
    # features/pdf-access-control.html
    "features/pdf-access-control.html": "https://sendpdfonline.com/usecase/pdf-access-control.html",
}

def create_redirect_html(incorrect_path, correct_url):
    """Create a redirect HTML file"""
    # Create directory if needed
    path_parts = incorrect_path.split('/')
    if len(path_parts) > 1:
        dir_path = '/'.join(path_parts[:-1])
        os.makedirs(dir_path, exist_ok=True)
    
    html_content = f"""<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="0; url={correct_url}">
    <title>Redirecting...</title>
    <script>
        // Immediate redirect
        window.location.replace("{correct_url}");
        
        // Fallback redirect
        setTimeout(function() {{
            window.location.href = "{correct_url}";
        }}, 100);
    </script>
    <link rel="canonical" href="{correct_url}">
</head>
<body>
    <div style="text-align: center; padding: 50px; font-family: Arial, sans-serif;">
        <h1>Redirecting...</h1>
        <p>If you are not redirected automatically, please <a href="{correct_url}">click here</a>.</p>
    </div>
</body>
</html>"""
    
    with open(incorrect_path, 'w', encoding='utf-8') as f:
        f.write(html_content)
    
    print(f"Created redirect: {incorrect_path} -> {correct_url}")

if __name__ == "__main__":
    print("Creating redirect files for broken URLs...")
    for incorrect_path, correct_url in REDIRECTS.items():
        create_redirect_html(incorrect_path, correct_url)
    print(f"\nCreated {len(REDIRECTS)} redirect files")

