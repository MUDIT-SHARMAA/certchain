<?php $__env->startSection('title','Blockchain Ledger'); ?>
<?php $__env->startSection('page-title','Blockchain Ledger'); ?>
<?php $__env->startSection('page-subtitle','Immutable chain of all issued certificates'); ?>

<?php $__env->startSection('content'); ?>

<div class="card p-5 mb-6 flex items-center gap-4 <?php echo e($chainValid['valid'] ? 'border-l-4 border-green-500' : 'border-l-4 border-red-500'); ?>">
    <span class="text-3xl"><?php echo e($chainValid['valid'] ? '🔗' : '🚨'); ?></span>
    <div class="flex-1">
        <p class="font-bold text-gray-800">
            Chain Status: <span class="<?php echo e($chainValid['valid'] ? 'text-green-600' : 'text-red-600'); ?>">
                <?php echo e($chainValid['valid'] ? 'VALID — All blocks intact' : 'CHAIN COMPROMISED'); ?>

            </span>
        </p>
        <p class="text-sm text-gray-500"><?php echo e($chainValid['total_blocks']); ?> blocks &bull; Algorithm: SHA-256 &bull; Type: Simulated Hash-Chain</p>
        <?php if(!$chainValid['valid']): ?>
        <?php $__currentLoopData = $chainValid['errors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p class="text-xs text-red-600 mt-1">⚠ <?php echo e($err); ?></p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
</div>


<div class="card p-5 mb-6">
    <h3 class="font-semibold text-gray-800 mb-4">Chain Visualization</h3>
    <div class="flex items-center gap-1 overflow-x-auto pb-2">
        <?php $recent = $blocks->take(6)->reverse(); ?>
        <div class="flex-shrink-0 w-24 h-16 rounded-lg bg-gray-200 flex items-center justify-center text-xs text-gray-500 font-mono">
            GENESIS<br><span class="text-gray-400">0000...0000</span>
        </div>
        <?php $__currentLoopData = $recent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $block): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="flex-shrink-0 text-gray-400 text-lg">→</div>
        <div class="flex-shrink-0 rounded-lg p-2 text-white text-center min-w-28" style="background: linear-gradient(135deg,#1a3a5c,#2a5298)">
            <p class="text-xs font-semibold text-yellow-300">Block #<?php echo e($block->block_index); ?></p>
            <p class="text-xs text-white/50 font-mono mt-1"><?php echo e(substr($block->block_hash, 0, 8)); ?>...</p>
            <p class="text-white/40 text-xs"><?php echo e($block->mined_at?->format('d M')); ?></p>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="flex-shrink-0 text-gray-400 text-lg">→ ∞</div>
    </div>
</div>


<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500">#</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500">Certificate ID</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500">Student</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500">Block Hash</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500">Prev Hash</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500">Integrity</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500">Mined</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 font-mono">
            <?php $__currentLoopData = $blocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $block): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="hover:bg-gray-50 transition">
                <td class="px-5 py-3 text-yellow-600 font-semibold"><?php echo e($block->block_index); ?></td>
                <td class="px-5 py-3">
                    <a href="<?php echo e(route('verify.certificate', $block->certificate_uid)); ?>" target="_blank" class="text-xs text-blue-600 hover:underline">
                        <?php echo e($block->certificate_uid); ?>

                    </a>
                </td>
                <td class="px-5 py-3 text-xs text-gray-600 font-sans">
                    <?php echo e($block->certificate->student_name ?? '—'); ?><br>
                    <span class="text-gray-400"><?php echo e($block->certificate->enrollment_number ?? ''); ?></span>
                </td>
                <td class="px-5 py-3 text-xs text-yellow-700"><?php echo e(substr($block->block_hash, 0, 20)); ?>...</td>
                <td class="px-5 py-3 text-xs text-gray-400"><?php echo e(substr($block->previous_hash, 0, 20)); ?>...</td>
                <td class="px-5 py-3">
                    <?php if($block->isIntact()): ?>
                    <span class="text-green-600 text-xs">✅ Intact</span>
                    <?php else: ?>
                    <span class="text-red-600 text-xs">🚨 Tampered!</span>
                    <?php endif; ?>
                </td>
                <td class="px-5 py-3 text-xs text-gray-400 font-sans"><?php echo e($block->mined_at?->format('d M Y H:i')); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div class="px-5 py-3 border-t border-gray-100">
        <?php echo e($blocks->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/macbook/Documents/Dtop/certchain/resources/views/admin/blockchain.blade.php ENDPATH**/ ?>