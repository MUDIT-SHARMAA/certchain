<?php $__env->startSection('title', isset($template) ? 'Edit Template' : 'Create Template'); ?>
<?php $__env->startSection('page-title', isset($template) ? 'Edit Template' : 'Create Certificate Template'); ?>
<?php $__env->startSection('page-subtitle','Design your certificate HTML. Use <?php echo e(placeholders); ?> for dynamic content.'); ?>

<?php $__env->startSection('content'); ?>
<form method="POST" action="<?php echo e(isset($template) ? route('admin.templates.update', $template) : route('admin.templates.store')); ?>">
<?php echo csrf_field(); ?>
<?php if(isset($template)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

<div class="grid lg:grid-cols-3 gap-6">
    
    <div class="lg:col-span-2 space-y-5">
        <div class="card p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Template Info</h3>
            <div class="grid md:grid-cols-3 gap-4 mb-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Template Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="<?php echo e(old('name', $template->name ?? '')); ?>" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="e.g. Participation Certificate">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Type <span class="text-red-500">*</span></label>
                    <select name="type" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php $__currentLoopData = ['participation','achievement','completion','winner']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($t); ?>" <?php echo e(old('type', $template->type ?? '') === $t ? 'selected' : ''); ?>><?php echo e(ucfirst($t)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Border Style</label>
                    <select name="border_style" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php $__currentLoopData = ['classic','modern','minimal']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($b); ?>" <?php echo e(old('border_style', $template->border_style ?? 'classic') === $b ? 'selected' : ''); ?>><?php echo e(ucfirst($b)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="flex items-center gap-2 mt-4">
                    <input type="checkbox" name="is_active" value="1" id="is_active"
                        <?php echo e(old('is_active', $template->is_active ?? true) ? 'checked' : ''); ?>

                        class="rounded border-gray-300 text-blue-600">
                    <label for="is_active" class="text-sm text-gray-700">Active (available for issuing)</label>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold text-gray-800">HTML Content <span class="text-red-500">*</span></h3>
                <button type="button" onclick="previewTemplate()" class="text-xs text-blue-600 hover:underline border border-blue-200 px-3 py-1 rounded-lg">👁 Preview</button>
            </div>
            <textarea name="html_content" id="htmlEditor" rows="22" required
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-xs font-mono focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                placeholder="Paste your certificate HTML here..."><?php echo e(old('html_content', $template->html_content ?? $defaultHtml ?? '')); ?></textarea>
        </div>
    </div>

    
    <div class="space-y-4">
        <div class="card p-5">
            <h4 class="font-semibold text-gray-800 mb-3">📋 Available Placeholders</h4>
            <p class="text-xs text-gray-500 mb-3">Click to copy. Use these in your HTML template.</p>
            <?php
            $placeholders = [
                '{{student_name}}'       => 'Student full name',
                '{{enrollment_number}}'  => 'Student enrollment no.',
                '{{student_branch}}'     => 'Branch/department',
                '{{student_year}}'       => 'Year (1st, 2nd...)',
                '{{event_name}}'         => 'Name of the event',
                '{{event_date}}'         => 'Event date',
                '{{event_type}}'         => 'Type of event',
                '{{venue}}'              => 'Event venue',
                '{{achievement}}'        => 'Achievement type',
                '{{description}}'        => 'Custom description',
                '{{issued_date}}'        => 'Date of issue',
                '{{issued_by}}'          => 'Issuing faculty name',
                '{{issuer_designation}}' => 'Faculty designation',
                '{{certificate_id}}'     => 'Unique cert ID',
                '{{block_hash}}'         => 'Blockchain hash',
                '{{college_name}}'       => 'College name',
                '{{{qr_code}}}'          => 'QR code SVG',
            ];
            ?>
            <div class="space-y-1.5 max-h-80 overflow-y-auto">
                <?php $__currentLoopData = $placeholders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ph => $desc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center justify-between gap-2 p-1.5 rounded hover:bg-gray-50 cursor-pointer" onclick="copyPlaceholder('<?php echo e($ph); ?>')">
                    <code class="text-xs bg-blue-50 text-blue-700 px-1.5 py-0.5 rounded"><?php echo e($ph); ?></code>
                    <span class="text-xs text-gray-400 flex-1 text-right"><?php echo e($desc); ?></span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="card p-5">
            <h4 class="font-semibold text-gray-800 mb-2">💡 Tips</h4>
            <ul class="text-xs text-gray-500 space-y-1.5">
                <li>• Use A4 landscape: <code class="bg-gray-100 px-1 rounded">297mm × 210mm</code></li>
                <li>• Use <code class="bg-gray-100 px-1 rounded">{{{qr_code}}}</code> (triple braces for QR code)</li>
                <li>• Google Fonts work via @import</li>
                <li>• Test with Preview before saving</li>
            </ul>
        </div>

        <div class="flex flex-col gap-2">
            <button type="submit" class="btn-primary text-center">
                <?php echo e(isset($template) ? '💾 Update Template' : '✅ Save Template'); ?>

            </button>
            <a href="<?php echo e(route('admin.templates')); ?>" class="text-center text-sm text-gray-400 hover:text-gray-600">Cancel</a>
        </div>
    </div>
</div>
</form>


<div id="previewModal" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-5xl h-[80vh] flex flex-col">
        <div class="flex items-center justify-between p-4 border-b">
            <h3 class="font-semibold">Template Preview (Sample Data)</h3>
            <button onclick="closePreview()" class="text-gray-400 hover:text-gray-600 text-xl">✕</button>
        </div>
        <iframe id="previewFrame" class="flex-1 w-full rounded-b-xl"></iframe>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function copyPlaceholder(text) {
    navigator.clipboard.writeText(text);
    const editor = document.getElementById('htmlEditor');
    const pos = editor.selectionStart;
    const val = editor.value;
    editor.value = val.substring(0, pos) + text + val.substring(pos);
    editor.focus();
}

function previewTemplate() {
    const html = document.getElementById('htmlEditor').value;
    const sample = {
        student_name: 'Rahul Sharma', enrollment_number: '0801CS211001',
        student_branch: 'Computer Science', student_year: '3rd Year',
        event_name: 'National Tech Symposium 2024', event_date: '15 Nov 2024',
        event_type: 'Symposium', venue: 'Main Auditorium',
        achievement: '1st Prize', description: 'for outstanding performance',
        issued_date: new Date().toLocaleDateString('en-GB', {day:'2-digit',month:'short',year:'numeric'}),
        issued_by: 'Dr. Priya Singh', issuer_designation: 'HOD, Computer Science',
        certificate_id: 'CERT-2024-AB1234', block_hash: 'a3f8c1e2b7d4...',
        college_name: 'Your College of Engineering', qr_code: ''
    };
    let rendered = html;
    Object.entries(sample).forEach(([k,v]) => {
        rendered = rendered.replaceAll(`{{${k}}}`, v).replaceAll(`@{${k}}`, v);
    });
    const frame = document.getElementById('previewFrame');
    frame.srcdoc = rendered;
    document.getElementById('previewModal').classList.remove('hidden');
}

function closePreview() {
    document.getElementById('previewModal').classList.add('hidden');
}
</script>
@endverbatim
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/macbook/Documents/Dtop/certchain/resources/views/admin/templates/create.blade.php ENDPATH**/ ?>