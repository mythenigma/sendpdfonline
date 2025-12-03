import os
from datetime import datetime

base_url = "https://sendpdfonline.com"
today = datetime.now().strftime("%Y-%m-%d")

# 获取所有HTML文件
html_files = []
excluded_dirs = ['grabify', 'flipbook', 'node_modules', 'maifle', '.git', 'localization']

for root, dirs, files in os.walk('.'):
    dirs[:] = [d for d in dirs if d not in excluded_dirs and not d.startswith('.')]
    if any(excluded in root for excluded in excluded_dirs):
        continue
    
    for file in files:
        if file.endswith('.html'):
            file_path = os.path.join(root, file)
            url_path = file_path[2:].replace('\\', '/').replace('./', '')
            html_files.append(url_path)

# 生成sitemap
xml_content = '<?xml version="1.0" encoding="UTF-8"?>\n'
xml_content += '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"\n'
xml_content += '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"\n'
xml_content += '        xmlns:xhtml="http://www.w3.org/1999/xhtml">\n'

html_files.sort()

for file_path in html_files:
    url = f"{base_url}/{file_path}"
    
    # 设置优先级和更新频率
    if file_path == 'index.html':
        priority = '1.0'
        changefreq = 'daily'
    elif file_path.startswith('features/en/'):
        priority = '0.9'
        changefreq = 'weekly'
    elif file_path.startswith('features/'):
        priority = '0.8'
        changefreq = 'weekly'
    elif file_path.startswith('article/'):
        priority = '0.7'
        changefreq = 'weekly'
    elif file_path.startswith('usecase/'):
        priority = '0.8'
        changefreq = 'weekly'
    elif '/index.html' in file_path:
        priority = '0.9'
        changefreq = 'weekly'
    elif file_path.startswith('german/') or file_path.startswith('japanese/') or file_path.startswith('arabic/') or file_path.startswith('french/') or file_path.startswith('chinese/') or file_path.startswith('korean/') or file_path.startswith('italian/') or file_path.startswith('spanish/'):
        priority = '0.8'
        changefreq = 'weekly'
    else:
        priority = '0.7'
        changefreq = 'monthly'
    
    xml_content += f'    <url>\n'
    xml_content += f'        <loc>{url}</loc>\n'
    xml_content += f'        <lastmod>{today}</lastmod>\n'
    xml_content += f'        <changefreq>{changefreq}</changefreq>\n'
    xml_content += f'        <priority>{priority}</priority>\n'
    xml_content += f'    </url>\n'

xml_content += '</urlset>'

# 保存sitemap
with open('sitemap.xml', 'w', encoding='utf-8') as f:
    f.write(xml_content)

print(f"✅ 新sitemap.xml已生成!")
print(f"�� 总URL数量: {len(html_files)}")
print(f"📅 最后更新日期: {today}")
print(f"\n📍 包含的主要目录:")
categories = {}
for f in html_files:
    cat = f.split('/')[0] if '/' in f else 'root'
    categories[cat] = categories.get(cat, 0) + 1

for cat, count in sorted(categories.items(), key=lambda x: -x[1])[:15]:
    print(f"  {cat}: {count} 个页面")
