<?php $__env->startSection('title','Manage Users'); ?>
<?php $__env->startSection('page-title','Manage Users'); ?>
<?php $__env->startSection('page-subtitle','Faculty, HODs, Coordinators and Admins'); ?>

<?php $__env->startSection('header-actions'); ?>
<a href="<?php echo e(route('admin.users.create')); ?>" class="btn-primary text-sm">+ Add User</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Name</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Email</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Employee ID</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Department</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Role</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-gray-50 transition">
                <td class="px-5 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-900/10 text-blue-900 flex items-center justify-center font-bold text-sm">
                            <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                        </div>
                        <div>
                            <p class="font-medium text-gray-800"><?php echo e($user->name); ?></p>
                            <p class="text-xs text-gray-400"><?php echo e($user->designation); ?></p>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-3 text-gray-600"><?php echo e($user->email); ?></td>
                <td class="px-5 py-3 text-gray-500 font-mono text-xs"><?php echo e($user->employee_id ?? '—'); ?></td>
                <td class="px-5 py-3 text-gray-600"><?php echo e($user->department ?? '—'); ?></td>
                <td class="px-5 py-3">
                    <?php
                    $roleColors = ['admin'=>'bg-purple-100 text-purple-700','hod'=>'bg-blue-100 text-blue-700','faculty'=>'bg-green-100 text-green-700','coordinator'=>'bg-yellow-100 text-yellow-700'];
                    $role = $user->roles->first()?->name ?? 'none';
                    ?>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium <?php echo e($roleColors[$role] ?? 'bg-gray-100 text-gray-600'); ?>">
                        <?php echo e(ucfirst($role)); ?>

                    </span>
                </td>
                <td class="px-5 py-3">
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium <?php echo e($user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600'); ?>">
                        <?php echo e($user->is_active ? 'Active' : 'Inactive'); ?>

                    </span>
                </td>
                <td class="px-5 py-3">
                    <div class="flex gap-2">
                        <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="text-xs text-blue-600 hover:underline">Edit</a>
                        <?php if($user->id !== auth()->id()): ?>
                        <form method="POST" action="<?php echo e(route('admin.users.delete', $user)); ?>" onsubmit="return confirm('Delete this user?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="text-xs text-red-500 hover:underline">Delete</button>
                        </form>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="7" class="px-5 py-10 text-center text-gray-400">No users found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="px-5 py-3 border-t border-gray-100"><?php echo e($users->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/macbook/Documents/Dtop/certchain/resources/views/admin/users/index.blade.php ENDPATH**/ ?>