#!/usr/bin/env python3
"""
Script to fix quality issues in HTML files:
1. Fix CSS issues (replace external CSS with CDN or inline)
2. Improve content quality
3. Enhance SEO (meta tags, structured data, canonical links)
4. Fix relative links to absolute links
"""

import os
import re
from pathlib import Path

# Files to fix based on Google Search Console issues
FILES_TO_FIX = [
    "article/offline-maipdf-de.html",
    "features/en/design/design-file-organization.html",
    "features/en/security/pdf_prevent_forward.html",
    "features/en/security/share-pdf-online-securely.html",
    "features/en/sharing/sharepdfsfilesonline.html",
    "features/en/sharing/Share_PDF_Online.html",
    "features/en/security/time-limits-pdf-files.html",
    "maiconvert-introduction.html",
    "features/en/security/sharesecure.html",
    "features/en/tracking/trackpdfopen.html",
    "german/email-verifizierung.html",
    "features/zh/sharing/waysmulti.html",
    "usecase/pdf-watermarking.html",
    "features/en/security/keycodeViet.html",
    "features/en/hosting/pdf-host-online.html",
]

BASE_URL = "https://sendpdfonline.com"

def fix_css_links(content):
    """Replace external CSS links with CDN versions"""
    # Replace maipdf.com CSS with CDN
    content = re.sub(
        r'href="https://maipdf\.com/[^"]*\.css"',
        lambda m: m.group(0).replace('https://maipdf.com/', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css'),
        content
    )
    # Ensure Font Awesome uses CDN
    content = re.sub(
        r'href="https://maipdf\.com/[^"]*fontawesome[^"]*"',
        'href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"',
        content
    )
    return content

def fix_relative_links(content, file_path):
    """Convert relative links to absolute links"""
    # Get directory depth
    depth = file_path.count('/') - 1
    base_path = '/'.join(file_path.split('/')[:-1])
    
    # Fix relative links in href
    def replace_link(match):
        link = match.group(1)
        if link.startswith('http'):
            return match.group(0)
        if link.startswith('/'):
            return f'href="{BASE_URL}{link}"'
        # Relative link
        if link.startswith('../'):
            # Calculate absolute path
            parts = base_path.split('/')
            up_count = link.count('../')
            new_parts = parts[:-up_count] if up_count <= len(parts) else []
            remaining = link.replace('../', '').replace('./', '')
            if new_parts:
                absolute = f"{BASE_URL}/{'/'.join(new_parts)}/{remaining}"
            else:
                absolute = f"{BASE_URL}/{remaining}"
            return f'href="{absolute}"'
        elif link.startswith('./'):
            link = link[2:]
            absolute = f"{BASE_URL}/{base_path}/{link}" if base_path else f"{BASE_URL}/{link}"
            return f'href="{absolute}"'
        else:
            absolute = f"{BASE_URL}/{base_path}/{link}" if base_path else f"{BASE_URL}/{link}"
            return f'href="{absolute}"'
    
    content = re.sub(r'href="([^"]+)"', replace_link, content)
    return content

def add_canonical_link(content, file_path):
    """Add canonical link if missing"""
    canonical_url = f"{BASE_URL}/{file_path}"
    if 'rel="canonical"' not in content:
        # Add after viewport meta
        content = re.sub(
            r'(<meta name="viewport"[^>]*>)',
            f'\\1\n    <link rel="canonical" href="{canonical_url}">',
            content
        )
    return content

def improve_seo(content, file_path):
    """Improve SEO meta tags"""
    # Ensure description exists
    if not re.search(r'<meta name="description"', content):
        # Try to extract from title or add default
        title_match = re.search(r'<title>([^<]+)</title>', content)
        if title_match:
            description = title_match.group(1) + " - MaiPDF secure PDF sharing platform"
            content = re.sub(
                r'(<meta name="viewport"[^>]*>)',
                f'\\1\n    <meta name="description" content="{description}">',
                content
            )
    
    # Add Open Graph tags if missing
    if 'property="og:url"' not in content:
        og_url = f"{BASE_URL}/{file_path}"
        title_match = re.search(r'<title>([^<]+)</title>', content)
        desc_match = re.search(r'<meta name="description" content="([^"]+)"', content)
        
        if title_match and desc_match:
            og_title = title_match.group(1)
            og_desc = desc_match.group(1)
            og_tags = f'''
    <meta property="og:type" content="article">
    <meta property="og:url" content="{og_url}">
    <meta property="og:title" content="{og_title}">
    <meta property="og:description" content="{og_desc}">'''
            content = re.sub(
                r'(<meta name="description"[^>]*>)',
                f'\\1{og_tags}',
                content
            )
    
    return content

def fix_file(file_path):
    """Fix a single file"""
    full_path = Path(file_path)
    if not full_path.exists():
        print(f"File not found: {file_path}")
        return False
    
    with open(full_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Apply fixes
    content = fix_css_links(content)
    content = fix_relative_links(content, file_path)
    content = add_canonical_link(content, file_path)
    content = improve_seo(content, file_path)
    
    # Write back
    with open(full_path, 'w', encoding='utf-8') as f:
        f.write(content)
    
    print(f"Fixed: {file_path}")
    return True

if __name__ == "__main__":
    print("Fixing quality issues in HTML files...")
    fixed = 0
    for file_path in FILES_TO_FIX:
        if fix_file(file_path):
            fixed += 1
    
    print(f"\nFixed {fixed} files out of {len(FILES_TO_FIX)}")

