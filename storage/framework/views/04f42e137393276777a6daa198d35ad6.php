

<?php $__env->startSection('title','Login'); ?>

<?php $__env->startSection('content'); ?>
  <h1 class="text-2xl font-bold text-center mb-6 text-brand-700">Admin Login</h1>

  <?php if($errors->any()): ?>
    <div class="mb-4 rounded-md bg-red-50 p-3 text-sm text-red-600">
      <ul class="list-disc list-inside">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
    <?php echo csrf_field(); ?>
    <div>
      <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
      <input id="email" type="email" name="email" required autofocus
             class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500" />
    </div>

    <div>
      <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
      <input id="password" type="password" name="password" required
             class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500" />
    </div>

    <div class="flex items-center justify-between">
      <label class="flex items-center text-sm">
        <input type="checkbox" name="remember" class="rounded border-gray-300 text-brand-600 focus:ring-brand-500">
        <span class="ml-2 text-gray-600">Remember me</span>
      </label>
      <a href="#" class="text-sm text-brand-600 hover:underline">Forgot password?</a>
      
    </div>

    <button type="submit"
            class="w-full bg-brand-600 text-white py-2 px-4 rounded-lg hover:bg-brand-700 focus:ring-2 focus:ring-brand-500">
      Login
    </button>
  </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\staff-portal\resources\views/auth/login.blade.php ENDPATH**/ ?>