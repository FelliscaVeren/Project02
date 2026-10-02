import re

file_path = '/Users/saerronn/Documents/Magang/Project02-real/resources/views/ppic/calendar.blade.php'

with open(file_path, 'r') as f:
    lines = f.readlines()

new_lines = []
in_qc_section = False
in_subheader_row = False
subheader_count = 0
in_data_row = False
td_count = 0

for line in lines:
    if 'SECTION QC: MONITORING KUALITAS PRODUK' in line:
        in_qc_section = True
        
    if 'END SECTION QC' in line:
        in_qc_section = False
        
    new_line = line
    
    if in_qc_section:
        # 1. Add x-data
        if '<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mt-5">' in line:
            new_line = line.replace(
                '<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mt-5">',
                '<div x-data="{ qcData: { shift1: true, shift2: true, shift3: false } }" class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mt-5">'
            )
            
        # 2. Shift 3 main header
        elif '<th colspan="4" class="p-2 text-center text-[10px] font-black text-amber-700 uppercase bg-amber-50/50">' in line:
            new_line = line.replace(
                '<th colspan="4" class="p-2 text-center text-[10px] font-black text-amber-700 uppercase bg-amber-50/50">',
                '<th colspan="4" x-show="qcData.shift3" class="p-2 text-center text-[10px] font-black text-amber-700 uppercase bg-amber-50/50">'
            )
            
        # 3. Sub-headers row (Jam 1, Jam 3, etc)
        elif '<tr class="border-b-2 border-slate-200 bg-slate-50 text-[9px] font-bold text-slate-400 uppercase">' in line:
            in_subheader_row = True
            subheader_count = 0
            
        elif in_subheader_row and '</tr>' in line:
            in_subheader_row = False
            
        elif in_subheader_row and '<th' in line:
            subheader_count += 1
            # The subheaders are: Item(1), Standar(2), S1(3,4,5,6), S2(7,8,9,10), S3(11,12,13,14)
            if subheader_count >= 11:
                new_line = line.replace('<th class="', '<th x-show="qcData.shift3" class="')
                
        # 4. Data rows
        elif '<tr class="hover:bg-slate-50/50 transition-colors">' in line or '<tr class="bg-slate-50/30 hover:bg-slate-50/70 transition-colors">' in line:
            in_data_row = True
            td_count = 0
            
        elif in_data_row and '</tr>' in line:
            in_data_row = False
            
        elif in_data_row and '<td' in line:
            # We skip columns that have rowspan. Let's count td elements per row.
            # Usually rows have 14 columns if no rowspan, but some rows have rowspan.
            # For simplicity, since the last 4 <td> are always Shift 3, we can just find them.
            # Wait, counting td precisely is tricky with rowspan.
            pass
            
        # Instead of td counting, we know Shift 3 cells look exactly like: 
        # <td class="p-2 text-center border-l border-slate-100"><span class="text-slate-300">—</span></td>
        # <td class="p-2 text-center"><span class="text-slate-300">—</span></td>
        # <td class="p-2 text-center border-r border-slate-200 bg-slate-50/30"><span class="text-slate-300">—</span></td>
        if '<td class="p-2 text-center"><span class="text-slate-300">—</span></td>' in line:
            new_line = line.replace('<td class="p-2 text-center">', '<td x-show="qcData.shift3" class="p-2 text-center">')
        elif '<td class="p-2 text-center bg-slate-50/30"><span class="text-slate-300">—</span></td>' in line:
            new_line = line.replace('<td class="p-2 text-center bg-slate-50/30">', '<td x-show="qcData.shift3" class="p-2 text-center bg-slate-50/30">')
        elif '<td class="p-2 text-center border-l border-slate-100"><span class="text-slate-300">—</span></td>' in line:
            new_line = line.replace('<td class="p-2 text-center border-l border-slate-100">', '<td x-show="qcData.shift3" class="p-2 text-center border-l border-slate-100">')
        elif '<td class="p-2 text-center border-r border-slate-200 bg-slate-50/30"><span class="text-slate-300">—</span></td>' in line:
            new_line = line.replace('<td class="p-2 text-center border-r border-slate-200 bg-slate-50/30">', '<td x-show="qcData.shift3" class="p-2 text-center border-r border-slate-200 bg-slate-50/30">')

        # 5. Footer grid cols
        elif '<div class="grid grid-cols-3 divide-x divide-slate-200">' in line:
            new_line = line.replace(
                '<div class="grid grid-cols-3 divide-x divide-slate-200">',
                '<div class="grid divide-x divide-slate-200" :class="qcData.shift3 ? \'grid-cols-3\' : \'grid-cols-2\'">'
            )
            
        # 6. Footer Shift 3 div
        elif '<!-- Shift 3 -->' in lines[lines.index(line) - 1] if lines.index(line) > 0 else False:
            if '<div class="py-4 pl-4">' in line:
                new_line = line.replace(
                    '<div class="py-4 pl-4">',
                    '<div x-show="qcData.shift3" class="py-4 pl-4">'
                )
                
    new_lines.append(new_line)

with open(file_path, 'w') as f:
    f.writelines(new_lines)
