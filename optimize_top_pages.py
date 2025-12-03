#!/usr/bin/env python3
"""
为高流量页面添加更多SEO元素：
- FAQ Schema
- HowTo Schema  
- 更丰富的内部链接
- 更好的keyword密度
- 更多的H2/H3标题
"""

import os
import re
from pathlib import Path

# 需要重点优化的页面
TOP_PAGES = [
    'article/share-pdf-online.html',  # 已手动优化
    'article/controlling-pdf-access.html',
    'article/pdf-tracking-analytics.html',
    'article/online-pdf-viewer.html',
    'article/secure-pdf-sharing-guide.html',
    'article/pdf-sharing-methods.html',
    'features/index.html',  # 已检查
    'index.html',
]

# FAQ模板（根据页面主题定制）
FAQ_TEMPLATES = {
    'controlling-pdf-access': {
        'questions': [
            {
                'q': 'How do I control who can access my PDF?',
                'a': 'MaiPDF provides multiple access control methods: password protection, email verification, IP whitelisting, and view limits. You can combine these methods for maximum security. Simply upload your PDF, configure your preferred access controls, and share the secure link.'
            },
            {
                'q': 'Can I limit how many times a PDF can be viewed?',
                'a': 'Yes, MaiPDF allows you to set view limits for any PDF. You can restrict access to a specific number of views (e.g., 10 views, 50 views) or unlimited views. Once the limit is reached, the link becomes inactive automatically.'
            },
            {
                'q': 'How do I revoke access to a shared PDF?',
                'a': 'You can revoke PDF access instantly from your MaiPDF dashboard. Simply disable the sharing link, and recipients will no longer be able to view the document. You can also set automatic expiration dates to revoke access at a specific time.'
            },
            {
                'q': 'What is IP whitelisting for PDFs?',
                'a': 'IP whitelisting allows you to restrict PDF access to specific IP addresses or IP ranges. This is useful for sharing documents with employees at your office or contractors at specific locations. Only devices from whitelisted IPs can access the PDF.'
            }
        ]
    },
    'pdf-tracking-analytics': {
        'questions': [
            {
                'q': 'What tracking metrics does MaiPDF provide?',
                'a': 'MaiPDF tracks comprehensive PDF engagement metrics including: view counts, time spent reading, geographic location, device type, browser information, page-by-page engagement, download attempts, print attempts, and access timestamps. All data is available in real-time.'
            },
            {
                'q': 'Can I see who viewed my PDF?',
                'a': 'Yes, if you enable email verification, you can see exactly who viewed your PDF along with their email address. Without email verification, you can track anonymous views with device, location, and behavior data.'
            },
            {
                'q': 'How do I get notified when someone views my PDF?',
                'a': 'MaiPDF can send real-time email notifications whenever someone accesses your PDF. You can configure notification preferences in your dashboard to receive alerts for specific events like first view, repeated views, or suspicious activity.'
            },
            {
                'q': 'Can I track which pages readers spend the most time on?',
                'a': 'Yes, MaiPDF provides page-level analytics showing exactly how long readers spend on each page of your PDF. This helps you understand which sections are most engaging and which might need improvement.'
            }
        ]
    },
    'online-pdf-viewer': {
        'questions': [
            {
                'q': 'Do recipients need to download software to view PDFs?',
                'a': 'No, MaiPDF\'s online PDF viewer works directly in web browsers on any device. Recipients simply click the link and can view the PDF immediately without downloading Adobe Reader or any other software.'
            },
            {
                'q': 'Does the online viewer work on mobile devices?',
                'a': 'Yes, MaiPDF\'s PDF viewer is fully responsive and optimized for mobile phones and tablets. It provides a smooth viewing experience with touch-optimized controls for zooming and page navigation.'
            },
            {
                'q': 'Can viewers download the PDF from the online viewer?',
                'a': 'You have full control. You can enable or disable downloads based on your security requirements. If downloads are disabled, viewers can only access the PDF online through the secure viewer.'
            },
            {
                'q': 'What browsers are supported?',
                'a': 'MaiPDF works with all modern web browsers including Chrome, Firefox, Safari, Edge, and mobile browsers. No plugins or extensions required - it works out of the box.'
            }
        ]
    },
    'secure-pdf-sharing-guide': {
        'questions': [
            {
                'q': 'What makes MaiPDF more secure than email attachments?',
                'a': 'Unlike email attachments which can be forwarded indefinitely, MaiPDF gives you continuous control. You can revoke access anytime, track all views, add password protection, set expiration dates, and prevent downloads. Email attachments offer none of these protections.'
            },
            {
                'q': 'Is MaiPDF GDPR compliant?',
                'a': 'Yes, MaiPDF is designed with privacy in mind and complies with GDPR requirements. We provide data processing agreements, allow data deletion, and give you full control over data collection and retention.'
            },
            {
                'q': 'How secure is the encryption used by MaiPDF?',
                'a': 'MaiPDF uses 256-bit SSL/TLS encryption for data transmission and AES-256 encryption for data storage. This is the same level of encryption used by banks and government agencies.'
            },
            {
                'q': 'Can I use MaiPDF for confidential business documents?',
                'a': 'Yes, MaiPDF is specifically designed for confidential document sharing. Features like DRM protection, dynamic watermarks, access control, and comprehensive auditing make it suitable for sensitive business proposals, contracts, and internal documents.'
            }
        ]
    },
    'pdf-sharing-methods': {
        'questions': [
            {
                'q': 'What are the different ways to share PDFs with MaiPDF?',
                'a': 'MaiPDF offers multiple sharing methods: secure links (via email, messaging, or social media), QR codes (for offline distribution and mobile access), embedded viewers (for websites), and direct email invitations. You can use multiple methods simultaneously.'
            },
            {
                'q': 'When should I use QR codes vs links for PDF sharing?',
                'a': 'Use QR codes when you need offline distribution (business cards, printed materials, presentations) or easy mobile access. Use links for digital distribution via email, messaging apps, or social media. QR codes are ideal for events, conferences, and physical marketing materials.'
            },
            {
                'q': 'Can I share the same PDF multiple ways?',
                'a': 'Yes, you can generate multiple sharing links with different security settings for the same PDF. For example, you might create a password-protected link for clients and an internal link with fewer restrictions for your team.'
            },
            {
                'q': 'How do I share PDFs anonymously?',
                'a': 'MaiPDF supports anonymous sharing. Simply generate a sharing link without requiring email verification. Recipients can view the PDF without revealing their identity, though you can still track anonymous usage statistics.'
            }
        ]
    }
}

def add_faq_schema(content, page_name):
    """添加FAQ Schema"""
    # 检查是否已有FAQ
    if 'FAQPage' in content:
        return content, False
    
    # 获取该页面的FAQ
    page_key = None
    for key in FAQ_TEMPLATES.keys():
        if key in page_name:
            page_key = key
            break
    
    if not page_key:
        return content, False
    
    faq_data = FAQ_TEMPLATES[page_key]
    
    # 生成FAQ JSON-LD
    faq_json = '''
    <!-- FAQ Schema -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": ['''
    
    for i, qa in enumerate(faq_data['questions']):
        faq_json += f'''
            {{
                "@type": "Question",
                "name": "{qa['q']}",
                "acceptedAnswer": {{
                    "@type": "Answer",
                    "text": "{qa['a']}"
                }}
            }}'''
        if i < len(faq_data['questions']) - 1:
            faq_json += ','
    
    faq_json += '''
        ]
    }
    </script>'''
    
    # 插入到</head>之前
    content = content.replace('</head>', f'{faq_json}\n</head>')
    
    # 添加FAQ HTML部分
    faq_html = '''
                <!-- FAQ Section -->
                <div class="mt-5" id="faq">
                    <h2><i class="fas fa-question-circle"></i> Frequently Asked Questions</h2>
                    <p class="lead mb-4">Get answers to common questions.</p>
                    
                    <div class="accordion" id="faqAccordion">'''
    
    for i, qa in enumerate(faq_data['questions']):
        show_class = 'show' if i == 0 else ''
        collapsed_class = '' if i == 0 else 'collapsed'
        faq_html += f'''
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button {collapsed_class}" type="button" data-bs-toggle="collapse" data-bs-target="#faq{i+1}">
                                    {qa['q']}
                                </button>
                            </h3>
                            <div id="faq{i+1}" class="accordion-collapse collapse {show_class}" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>{qa['a']}</p>
                                </div>
                            </div>
                        </div>'''
    
    faq_html += '''
                    </div>
                </div>'''
    
    # 尝试插入FAQ部分
    if 'cta-section' in content:
        content = content.replace('<div class="cta-section">', f'{faq_html}\n\n            <div class="cta-section">')
    elif '</div>\n\n    <footer' in content:
        content = content.replace('</div>\n\n    <footer', f'{faq_html}\n            </div>\n\n    <footer')
    
    return content, True

def enhance_content_keywords(content):
    """增强关键词密度"""
    # 添加更多关键词变体到现有段落
    keyword_enhancements = {
        'share PDF': 'share PDF online',
        'PDF sharing': 'secure PDF sharing',
        'track PDF': 'track PDF views',
        'PDF security': 'PDF security features',
        'access control': 'PDF access control',
    }
    
    modified = False
    for old_phrase, new_phrase in keyword_enhancements.items():
        # 只替换第一次出现（避免过度优化）
        if old_phrase in content and new_phrase not in content:
            content = content.replace(old_phrase, new_phrase, 1)
            modified = True
    
    return content, modified

def process_page(file_path):
    """处理单个页面"""
    try:
        with open(file_path, 'r', encoding='utf-8') as f:
            content = f.read()
        
        original_content = content
        page_name = os.path.basename(file_path)
        
        # 添加FAQ Schema
        content, faq_added = add_faq_schema(content, page_name)
        
        # 增强关键词
        content, keywords_enhanced = enhance_content_keywords(content)
        
        # 更新dateModified
        if 'dateModified' in content:
            content = re.sub(
                r'"dateModified":\s*"[^"]*"',
                '"dateModified": "2025-12-03"',
                content
            )
        
        # 保存修改
        if content != original_content:
            with open(file_path, 'w', encoding='utf-8') as f:
                f.write(content)
            
            changes = []
            if faq_added:
                changes.append('FAQ Schema')
            if keywords_enhanced:
                changes.append('Keywords')
            
            return True, changes
        
        return False, []
    
    except Exception as e:
        print(f"❌ Error: {str(e)}")
        return False, []

def main():
    """主函数"""
    print("🎯 开始优化高流量页面...\n")
    
    base_dir = Path('/Users/joehuang/Documents/GitHub/sendpdfonline')
    total_updated = 0
    
    for page_path in TOP_PAGES:
        full_path = base_dir / page_path
        
        if not full_path.exists():
            print(f"⚠️  页面不存在: {page_path}")
            continue
        
        updated, changes = process_page(full_path)
        
        if updated:
            total_updated += 1
            change_str = ', '.join(changes) if changes else 'Updated'
            print(f"✅ {page_path}")
            print(f"   📝 {change_str}\n")
        else:
            print(f"⏭️  {page_path} - 已是最新\n")
    
    print(f"\n📊 优化完成! 共更新 {total_updated}/{len(TOP_PAGES)} 个页面")

if __name__ == '__main__':
    main()
