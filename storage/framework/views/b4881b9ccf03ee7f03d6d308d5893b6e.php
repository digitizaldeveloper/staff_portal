

<?php $__env->startSection('page-heading', 'Job Applications'); ?>

<?php $__env->startSection('content'); ?>

<div class="max-w-6xl mx-auto">

    <!-- <h1 class="text-3xl font-bold mb-6">All Job Applications</h1> -->

    <?php if(session('success')): ?>
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="py-3 px-4 font-semibold">#</th>
                    <th class="py-3 px-4 font-semibold">Applicant Name</th>
                    <th class="py-3 px-4 font-semibold">Email</th>
                    <th class="py-3 px-4 font-semibold">Phone</th>
                    <th class="py-3 px-4 font-semibold">Job Title</th>
                    <th class="py-3 px-4 font-semibold">Resume</th>
                    <th class="py-3 px-4 font-semibold">Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-4"><?php echo e($index + 1); ?></td>

                    <td class="py-3 px-4 font-semibold">
                        <?php echo e($app->name); ?>

                    </td>

                    <td class="py-3 px-4"><?php echo e($app->email); ?></td>

                    <td class="py-3 px-4"><?php echo e($app->phone); ?></td>

                    <td class="py-3 px-4 text-blue-600">
                        <?php echo e($app->job ? $app->job->title : 'N/A'); ?>

                    </td>

                    <td class="py-3 px-4">
                        <?php if($app->resume): ?>
                            <a href="<?php echo e(asset('resumes/' . $app->resume)); ?>"
                               target="_blank"
                               class="text-green-600 underline">
                                View Resume
                            </a>
                        <?php else: ?>
                            <span class="text-gray-500 text-sm">No File</span>
                        <?php endif; ?>
                    </td>

                    <td class="py-3 px-4">
                        <button onclick="openDeleteModal(<?php echo e($app->id); ?>)"
                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                            Delete
                        </button>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

</div>


<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-40 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-semibold mb-4">Delete Application?</h2>
        <p class="text-gray-600 mb-6">Are you sure you want to delete this application?</p>

        <form id="deleteForm" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>

            <div class="flex justify-end gap-3">
                <button type="button"
                        onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Cancel
                </button>

                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Delete
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    function openDeleteModal(id) {
        document.getElementById("deleteModal").classList.remove("hidden");
        document.getElementById("deleteForm").action =
            "/admin/applications/delete/" + id;
    }

    function closeDeleteModal() {
        document.getElementById("deleteModal").classList.add("hidden");
    }
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\digitizal\Downloads\staff_portal\resources\views/admin/jobs/job_applications.blade.php ENDPATH**/ ?>