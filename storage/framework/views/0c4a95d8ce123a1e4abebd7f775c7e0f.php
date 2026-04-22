<?php $__env->startSection('title','Certificates'); ?>
<?php $__env->startSection('page-title','Certificates'); ?>
<?php $__env->startSection('page-subtitle','All issued blockchain-recorded certificates'); ?>

<?php $__env->startSection('header-actions'); ?>
<a href="<?php echo e(route('certificates.bulk')); ?>" class="btn-gold text-sm mr-2">📦 Bulk Issue</a>
<a href="<?php echo e(route('certificates.create')); ?>" class="btn-primary text-sm">+ Issue New</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<form method="GET" class="card p-4 mb-5 flex flex-wrap gap-3 items-end">
    <div class="flex-1 min-w-48">
        <label class="block text-xs text-gray-500 mb-1">Search</label>
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Name, enrollment no., cert ID…"
            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label class="block text-xs text-gray-500 mb-1">Event</label>
        <select name="event_id" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All Events</option>
            <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($event->id); ?>" <?php echo e(request('event_id') == $event->id ? 'selected' : ''); ?>><?php echo e($event->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <button type="submit" class="btn-primary text-sm">Filter</button>
    <a href="<?php echo e(route('certificates.index')); ?>" class="text-sm text-gray-400 hover:text-gray-600">Clear</a>
</form>


<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Certificate ID</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Student</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Event</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Achievement</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Blockchain</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php $__empty_1 = true; $__currentLoopData = $certificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-gray-50 transition">
                <td class="px-5 py-3">
                    <p class="font-mono text-xs text-blue-600"><?php echo e($cert->certificate_id); ?></p>
                    <p class="text-xs text-gray-400"><?php echo e($cert->issued_date?->format('d M Y')); ?></p>
                </td>
                <td class="px-5 py-3">
                    <p class="font-medium text-gray-800"><?php echo e($cert->student_name); ?></p>
                    <p class="text-xs text-gray-400"><?php echo e($cert->enrollment_number); ?></p>
                </td>
                <td class="px-5 py-3">
                    <p class="text-gray-700"><?php echo e(Str::limit($cert->event->name ?? '—', 30)); ?></p>
                </td>
                <td class="px-5 py-3 text-gray-600"><?php echo e($cert->achievement); ?></td>
                <td class="px-5 py-3">
                    <?php if($cert->blockchainBlock): ?>
                    <span class="text-green-600 text-xs flex items-center gap-1">⛓ Block #<?php echo e($cert->blockchainBlock->block_index); ?></span>
                    <?php else: ?>
                    <span class="text-red-500 text-xs">⚠ No block</span>
                    <?php endif; ?>
                </td>
                <td class="px-5 py-3">
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium <?php echo e($cert->status === 'issued' ? 'badge-verified' : 'badge-revoked'); ?>">
                        <?php echo e(ucfirst($cert->status)); ?>

                    </span>
                    <?php if($cert->email_sent): ?> <span class="text-xs text-gray-400 ml-1">📧</span> <?php endif; ?>
                </td>
                <td class="px-5 py-3">
                    <div class="flex gap-2">
                        <a href="<?php echo e(route('certificates.show', $cert)); ?>" class="text-xs text-blue-600 hover:underline">View</a>
                        <a href="<?php echo e(route('certificates.download', $cert)); ?>" class="text-xs text-gray-500 hover:underline">PDF</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="7" class="px-5 py-10 text-center text-gray-400">
                No certificates found.
                <a href="<?php echo e(route('certificates.create')); ?>" class="text-blue-600 hover:underline ml-1">Issue one →</a>
            </td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="px-5 py-3 border-t border-gray-100">
        <?php echo e($certificates->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/macbook/Desktop/certchain/resources/views/certificates/index.blade.php ENDPATH**/ ?>