<?php $__env->startSection('title','Bulk Issue Certificates'); ?>
<?php $__env->startSection('page-title','Bulk Issue Certificates'); ?>
<?php $__env->startSection('page-subtitle','Issue certificates to multiple students at once'); ?>

<?php $__env->startSection('content'); ?>
<div class="grid lg:grid-cols-3 gap-6">
<form method="POST" action="<?php echo e(route('certificates.bulk.store')); ?>" id="bulkForm" class="lg:col-span-2">
<?php echo csrf_field(); ?>
    <div class="space-y-5">
        
        <div class="card p-6">
            <h3 class="font-semibold text-gray-800 mb-4">📅 Event & Template</h3>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Event <span class="text-red-500">*</span></label>
                    <select name="event_id" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select an event…</option>
                        <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($event->id); ?>"><?php echo e($event->name); ?> (<?php echo e($event->event_date?->format('d M Y')); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Template <span class="text-red-500">*</span></label>
                    <select name="template_id" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select a template…</option>
                        <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($t->id); ?>"><?php echo e($t->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>

        
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800">🎓 Students List</h3>
                <button type="button" onclick="addRow()" class="text-sm text-blue-600 hover:underline">+ Add Row</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm" id="studentsTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left px-3 py-2 text-xs text-gray-500 font-semibold">Full Name *</th>
                            <th class="text-left px-3 py-2 text-xs text-gray-500 font-semibold">Enrollment No *</th>
                            <th class="text-left px-3 py-2 text-xs text-gray-500 font-semibold">Email *</th>
                            <th class="text-left px-3 py-2 text-xs text-gray-500 font-semibold">Branch</th>
                            <th class="text-left px-3 py-2 text-xs text-gray-500 font-semibold">Year</th>
                            <th class="text-left px-3 py-2 text-xs text-gray-500 font-semibold">Achievement</th>
                            <th class="px-3 py-2"></th>
                        </tr>
                    </thead>
                    <tbody id="studentsBody">
                        <?php for($i = 0; $i < 3; $i++): ?>
                        <tr class="border-t border-gray-100">
                            <td class="px-2 py-1.5"><input type="text" name="students[<?php echo e($i); ?>][student_name]" required class="w-full border border-gray-200 rounded px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400" placeholder="Student name"></td>
                            <td class="px-2 py-1.5"><input type="text" name="students[<?php echo e($i); ?>][enrollment_number]" required class="w-full border border-gray-200 rounded px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400" placeholder="0801CS21XXXX"></td>
                            <td class="px-2 py-1.5"><input type="email" name="students[<?php echo e($i); ?>][student_email]" required class="w-full border border-gray-200 rounded px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400" placeholder="email@college.edu"></td>
                            <td class="px-2 py-1.5"><input type="text" name="students[<?php echo e($i); ?>][student_branch]" class="w-full border border-gray-200 rounded px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400" placeholder="CSE"></td>
                            <td class="px-2 py-1.5"><input type="text" name="students[<?php echo e($i); ?>][student_year]" class="w-full border border-gray-200 rounded px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400" placeholder="3rd Year"></td>
                            <td class="px-2 py-1.5">
                                <select name="students[<?php echo e($i); ?>][achievement]" class="border border-gray-200 rounded px-2 py-1 text-xs focus:outline-none">
                                    <?php $__currentLoopData = ['Participation','1st Prize','2nd Prize','3rd Prize','Best Project','Special Award']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option><?php echo e($a); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </td>
                            <td class="px-2 py-1.5"><button type="button" onclick="removeRow(this)" class="text-red-400 hover:text-red-600 text-xs">✕</button></td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
            <p class="text-xs text-gray-400 mt-2" id="rowCount">3 students</p>
        </div>

        <div class="card p-5 flex items-center gap-4">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="send_emails" value="1" checked class="rounded border-gray-300 text-blue-600">
                <div>
                    <p class="text-sm font-medium text-gray-700">Send emails to all students</p>
                    <p class="text-xs text-gray-400">Each student will receive their certificate PDF via email</p>
                </div>
            </label>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-xl font-semibold text-sm hover:from-blue-800 transition-all shadow-lg shadow-blue-900/20">
                ⛓ Issue All Certificates on Blockchain
            </button>
            <a href="<?php echo e(route('certificates.index')); ?>" class="px-6 py-3 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50">Cancel</a>
        </div>
    </div>
</form>


<div class="space-y-4">
    <div class="card p-5">
        <h4 class="font-semibold text-gray-800 mb-3">💡 Tips</h4>
        <ul class="text-xs text-gray-500 space-y-2">
            <li>• Each student gets a unique Certificate ID</li>
            <li>• Enrollment number must be unique per event</li>
            <li>• All certificates are individually blockchain-recorded</li>
            <li>• PDFs are auto-generated from the selected template</li>
            <li>• Emails are sent in the background</li>
        </ul>
    </div>
    <div class="card p-5">
        <h4 class="font-semibold text-gray-800 mb-2">Issued Date</h4>
        <input type="date" name="issued_date" form="bulkForm" value="<?php echo e(date('Y-m-d')); ?>"
            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        <p class="text-xs text-gray-400 mt-1">Applied to all certificates in this batch</p>
    </div>
</div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
let rowIdx = 3;
function addRow() {
    const tbody = document.getElementById('studentsBody');
    const i = rowIdx++;
    const tr = document.createElement('tr');
    tr.className = 'border-t border-gray-100';
    tr.innerHTML = `
        <td class="px-2 py-1.5"><input type="text" name="students[${i}][student_name]" required class="w-full border border-gray-200 rounded px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400" placeholder="Student name"></td>
        <td class="px-2 py-1.5"><input type="text" name="students[${i}][enrollment_number]" required class="w-full border border-gray-200 rounded px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400" placeholder="0801CS21XXXX"></td>
        <td class="px-2 py-1.5"><input type="email" name="students[${i}][student_email]" required class="w-full border border-gray-200 rounded px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400" placeholder="email@college.edu"></td>
        <td class="px-2 py-1.5"><input type="text" name="students[${i}][student_branch]" class="w-full border border-gray-200 rounded px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400" placeholder="CSE"></td>
        <td class="px-2 py-1.5"><input type="text" name="students[${i}][student_year]" class="w-full border border-gray-200 rounded px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400" placeholder="3rd Year"></td>
        <td class="px-2 py-1.5"><select name="students[${i}][achievement]" class="border border-gray-200 rounded px-2 py-1 text-xs focus:outline-none">
            <option>Participation</option><option>1st Prize</option><option>2nd Prize</option><option>3rd Prize</option><option>Best Project</option>
        </select></td>
        <td class="px-2 py-1.5"><button type="button" onclick="removeRow(this)" class="text-red-400 hover:text-red-600 text-xs">✕</button></td>`;
    tbody.appendChild(tr);
    updateCount();
}
function removeRow(btn) {
    const rows = document.getElementById('studentsBody').querySelectorAll('tr');
    if (rows.length <= 1) return;
    btn.closest('tr').remove();
    updateCount();
}
function updateCount() {
    const n = document.getElementById('studentsBody').querySelectorAll('tr').length;
    document.getElementById('rowCount').textContent = n + ' student' + (n !== 1 ? 's' : '');
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/macbook/Documents/Dtop/certchain/resources/views/certificates/bulk.blade.php ENDPATH**/ ?>