<?php $__env->startSection('title', 'Edit Template'); ?>
<?php $__env->startSection('page-title', 'Edit Certificate Template'); ?>
<?php $__env->startSection('page-subtitle', 'Modify the HTML design and settings'); ?>

<?php $__env->startSection('content'); ?>
    <form method="POST" action="<?php echo e(route('admin.templates.update', $template)); ?>">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="grid lg:grid-cols-3 gap-6">

            
            <div class="lg:col-span-2 space-y-5">
                <div class="card p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">🎨 Template Details</h3>
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Template Name <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="name" value="<?php echo e(old('name', $template->name)); ?>" required
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Type <span
                                    class="text-red-500">*</span></label>
                            <select name="type" required
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <?php $__currentLoopData = ['participation', 'achievement', 'completion', 'winner']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($t); ?>" <?php echo e($template->type === $t ? 'selected' : ''); ?>><?php echo e(ucfirst($t)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Border Style</label>
                            <select name="border_style"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <?php $__currentLoopData = ['classic', 'modern', 'minimal']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($b); ?>" <?php echo e($template->border_style === $b ? 'selected' : ''); ?>>
                                        <?php echo e(ucfirst($b)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="flex items-center gap-3 mt-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" <?php echo e($template->is_active ? 'checked' : ''); ?> class="rounded border-gray-300">
                                <span class="text-sm text-gray-700">Active (available for use)</span>
                            </label>
                        </div>
                    </div>

                    <label class="block text-sm font-medium text-gray-700 mb-1.5">HTML Template <span
                            class="text-red-500">*</span></label>
                    <textarea name="html_content" rows="22" required id="htmlEditor"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-xs font-mono focus:outline-none focus:ring-2 focus:ring-blue-500 resize-y"><?php echo e(old('html_content', $template->html_content)); ?></textarea>
                    <p class="text-xs text-gray-400 mt-1">Use <code
                            class="bg-gray-100 px-1 rounded">&#123;&#123;student_name&#125;&#125;</code>, <code
                            class="bg-gray-100 px-1 rounded">&#123;&#123;event_name&#125;&#125;</code> etc. as placeholders.
                    </p>
                </div>
            </div>

            
            <div class="space-y-4">
                <div class="card p-5">
                    <h4 class="font-semibold text-gray-800 mb-3">📋 Available Placeholders</h4>
                    <p class="text-xs text-gray-400 mb-2">Click any placeholder to insert it at cursor position in the
                        editor.</p>
                    <div class="text-xs space-y-1 font-mono text-blue-700">
                        <?php
                            $placeholders = [
                                'student_name',
                                'enrollment_number',
                                'student_branch',
                                'student_year',
                                'event_name',
                                'event_date',
                                'event_type',
                                'venue',
                                'achievement',
                                'description',
                                'issued_date',
                                'issued_by',
                                'issuer_designation',
                                'certificate_id',
                                'block_hash',
                                'college_name'
                            ];
                        ?>
                        <?php $__currentLoopData = $placeholders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ph): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $phText = '{{' . $ph . '}}'; ?>
                        <p class="bg-blue-50 px-2 py-1 rounded cursor-pointer hover:bg-blue-100"
                            onclick="insertPlaceholder(this.dataset.ph)"
                            data-ph="<?php echo e($phText); ?>">
                                &#123;&#123;<?php echo e($ph); ?>&#125;&#125;
                        </p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                        <?php $qrText = '{{{qr_code}}}'; ?>
                        <p class="bg-yellow-50 px-2 py-1 rounded text-yellow-700 cursor-pointer hover:bg-yellow-100"
                            onclick="insertPlaceholder(this.dataset.ph)"
                            data-ph="<?php echo e($qrText); ?>">
                                &#123;&#123;&#123;qr_code&#125;&#125;&#125; (triple braces)
                        </p>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <a href="<?php echo e(route('admin.templates.preview', $template)); ?>" target="_blank"
                        class="w-full text-center py-2.5 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50 transition">
                        👁 Preview Template
                    </a>
                    <button type="submit"
                        class="w-full py-2.5 bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-xl font-semibold text-sm hover:from-blue-800 transition-all shadow-lg">
                        💾 Save Changes
                    </button>
                    <a href="<?php echo e(route('admin.templates')); ?>"
                        class="text-center text-sm text-gray-400 hover:text-gray-600">Cancel</a>
                </div>
            </div>
        </div>
    </form>

    <?php $__env->startPush('scripts'); ?>
        <script>
            function insertPlaceholder(text) {
                const ta = document.getElementById('htmlEditor');
                const start = ta.selectionStart;
                const end = ta.selectionEnd;
                ta.value = ta.value.substring(0, start) + text + ta.value.substring(end);
                ta.selectionStart = ta.selectionEnd = start + text.length;
                ta.focus();
            }
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/macbook/Documents/Dtop/certchain/resources/views/admin/templates/edit.blade.php ENDPATH**/ ?>