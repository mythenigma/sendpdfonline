#!/usr/bin/env python3
"""
Remove .html extensions from all URLs in sitemap.xml for Cloudflare Pages
"""
import re
import sys

def update_sitemap():
    """Update sitemap.xml to remove .html extensions"""
    
    try:
        with open('sitemap.xml', 'r', encoding='utf-8') as f:
            content = f.read()
        
        print(f"Read {len(content)} characters from sitemap.xml")
        
        # Count .html occurrences before
        html_count_before = content.count('.html</loc>')
        print(f"Found {html_count_before} URLs with .html extension")
        
        # Replace .html in <loc> tags with nothing
        # Pattern matches: <loc>URL.html</loc> and replaces with <loc>URL</loc>
        updated_content = re.sub(
            r'(<loc>https://sendpdfonline\.com/[^<]*?)\.html(</loc>)',
            r'\1\2',
            content
        )
        
        # Also handle index.html -> / (root directory)
        updated_content = re.sub(
            r'(<loc>https://sendpdfonline\.com/[^<]*?)/index(</loc>)',
            r'\1\2',
            updated_content
        )
        
        # Count .html occurrences after
        html_count_after = updated_content.count('.html</loc>')
        print(f"After update: {html_count_after} URLs still have .html")
        
        # Write the updated content back
        with open('sitemap.xml', 'w', encoding='utf-8') as f:
            f.write(updated_content)
        
        print("✅ Sitemap updated successfully!")
        print(f"Removed .html from {html_count_before - html_count_after} URLs")
        
    except Exception as e:
        print(f"❌ Error: {e}")
        sys.exit(1)

if __name__ == '__main__':
    update_sitemap()
