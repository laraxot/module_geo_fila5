#!/usr/bin/env python3
"""Structural comparison of reference vs local HTML for segnalazione pages."""
import re
import os

RESEARCH_DIR = '/var/www/_bases/base_fixcity_fila5/.planning/research'

def extract_structure(filepath):
    with open(filepath, 'r') as f:
        content = f.read()
    # Remove scripts and comments
    content = re.sub(r'<script[^>]*>.*?</script>', '', content, flags=re.DOTALL)
    content = re.sub(r'<!--.*?-->', '', content, flags=re.DOTALL)
    
    elements = []
    for match in re.finditer(r'<(\w+)([^>]*)>', content):
        tag = match.group(1)
        attrs = match.group(2)
        classes = re.findall(r'class=["\']([^"\']*)["\']', attrs)
        ids = re.findall(r'id=["\']([^"\']*)["\']', attrs)
        type_val = re.findall(r'type=["\']([^"\']*)["\']', attrs)
        if classes or ids or tag in ['h1','h2','h3','h4','h5','h6','form','input','button','select','textarea','main','section','nav','aside','article','header','footer']:
            elements.append({
                'tag': tag,
                'classes': classes[0] if classes else '',
                'ids': ids[0] if ids else '',
                'type': type_val[0] if type_val else ''
            })
    return elements

pages = [
    'segnalazione-01-privacy',
    'segnalazione-02-dati', 
    'segnalazione-03-riepilogo',
    'segnalazione-04-conferma',
    'segnalazione-area-personale',
    'segnalazioni-elenco',
    'segnalazione-dettaglio',
]

output = []
output.append('# HTML Structural Differences — Design Comuni Segnalazione Pages\n')
output.append('**Date:** 2026-04-07\n')
output.append('**Method:** Automated class/element extraction from reference vs local rendered HTML\n')
output.append('**Goal:** Identify ALL structural differences to fix CSS/JS for visual parity\n\n')

for page in pages:
    ref_file = os.path.join(RESEARCH_DIR, f'ref-{page}.html')
    local_file = os.path.join(RESEARCH_DIR, f'local-{page}.html')
    
    if not os.path.exists(ref_file):
        output.append(f'## {page}\n⚠️ Reference file not available\n')
        continue
    
    if not os.path.exists(local_file):
        output.append(f'## {page}\n⚠️ Local file not available\n')
        continue
    
    ref_el = extract_structure(ref_file)
    local_el = extract_structure(local_file)
    
    output.append(f'---\n## {page}\n')
    output.append(f'- **Reference elements:** {len(ref_el)}')
    output.append(f'- **Local elements:** {len(local_el)}')
    output.append(f'- **Structural match:** {"✅" if abs(len(ref_el) - len(local_el)) < 10 else "❌"} ({abs(len(ref_el) - len(local_el))} element difference)\n')
    
    # Extract main content classes for comparison
    ref_classes = set()
    local_classes = set()
    ref_tags = set()
    local_tags = set()
    
    for el in ref_el:
        if el['classes']:
            for c in el['classes'].split():
                ref_classes.add(c)
        ref_tags.add(el['tag'])
    
    for el in local_el:
        if el['classes']:
            for c in el['classes'].split():
                local_classes.add(c)
        local_tags.add(el['tag'])
    
    # Classes only in reference (missing locally)
    missing_classes = ref_classes - local_classes
    # Classes only in local (extra)
    extra_classes = local_classes - ref_classes
    
    output.append(f'### Missing Classes (in reference but NOT in local): {len(missing_classes)}\n')
    if missing_classes:
        # Group by category
        categories = {
            'Typography': [],
            'Layout': [],
            'Buttons': [],
            'Forms': [],
            'Cards': [],
            'Stepper': [],
            'Colors': [],
            'Icons': [],
            'Spacing': [],
            'Navigation': [],
            'Other': []
        }
        
        for c in sorted(missing_classes):
            if any(kw in c for kw in ['title-', 'text-', 'font-', 'lora', 'paragraph', 'subtitle', 'heading']):
                categories['Typography'].append(c)
            elif any(kw in c for kw in ['col-', 'row', 'container', 'offset', 'd-', 'flex', 'order-', 'justify', 'align']):
                categories['Layout'].append(c)
            elif any(kw in c for kw in ['btn', 'button']):
                categories['Buttons'].append(c)
            elif any(kw in c for kw in ['form', 'input', 'checkbox', 'check', 'select', 'textarea', 'field']):
                categories['Forms'].append(c)
            elif any(kw in c for kw in ['card', 'teaser']):
                categories['Cards'].append(c)
            elif any(kw in c for kw in ['stepper', 'step', 'progress']):
                categories['Stepper'].append(c)
            elif any(kw in c for kw in ['bg-', 't-', 'color', 'shadow']):
                categories['Colors'].append(c)
            elif any(kw in c for kw in ['icon', 'sprite', 'svg']):
                categories['Icons'].append(c)
            elif any(kw in c for kw in ['p-', 'm-', 'mb-', 'mt-', 'ml-', 'mr-', 'px-', 'py-']):
                categories['Spacing'].append(c)
            elif any(kw in c for kw in ['breadcrumb', 'nav', 'menu', 'link']):
                categories['Navigation'].append(c)
            else:
                categories['Other'].append(c)
        
        for cat, items in categories.items():
            if items:
                output.append(f'**{cat}:** {", ".join(items[:15])}' + (f' ...(+{len(items)-15})' if len(items) > 15 else ''))
        output.append('')
    
    output.append(f'### Extra Classes (in local but NOT in reference): {len(extra_classes)}\n')
    if extra_classes:
        # Show Tailwind-specific classes
        tw_classes = [c for c in sorted(extra_classes) if any(kw in c for kw in ['text-', 'bg-', 'border-', 'rounded', 'font-', 'px-', 'py-', 'mt-', 'mb-', 'ml-', 'mr-', 'gap-', 'w-', 'h-', 'max-w', 'mx-', 'ring', 'focus:', 'hover:', 'disabled:', 'md:', 'lg:', 'sm:'])]
        non_tw = [c for c in sorted(extra_classes) if c not in tw_classes]
        
        if tw_classes:
            output.append(f'**Tailwind utilities (need CSS overrides):** {", ".join(tw_classes[:20])}' + (f' ...(+{len(tw_classes)-20})' if len(tw_classes) > 20 else ''))
        if non_tw:
            output.append(f'**Other:** {", ".join(non_tw[:20])}' + (f' ...(+{len(non_tw)-20})' if len(non_tw) > 20 else ''))
        output.append('')

# Write output
output_path = os.path.join('/var/www/_bases/base_fixcity_fila5', '.planning/research/html-structural-diff.md')
with open(output_path, 'w') as f:
    f.write('\n'.join(output))
print(f'Written structural diff to {output_path}')
print(f'Lines: {len(output)}')
