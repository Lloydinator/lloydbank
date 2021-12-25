<template>
  <footer class="relative bg-gray-300 mt-8 pt-8 pb-6">
    <div class="container mx-auto px-4">
      <div class="flex flex-wrap">
        <div class="w-full lg:w-6/12 px-4">
          <h4 class="text-3xl font-semibold">LLOYDBANK</h4>
        </div>
        <div class="w-full lg:w-6/12 px-4">
          <div class="flex flex-wrap items-top mb-6">
            <div class="w-full lg:w-4/12 px-4 ml-auto">
              <ul class="list-unstyled">
                <li>
                  <Link
                    class="text-gray-700 hover:text-gray-900 font-semibold block pb-2 text-sm"
                    href="#"
                    >Terms &amp; Conditions</Link
                  >
                </li>
                <li>
                  <Link
                    class="text-gray-700 hover:text-gray-900 font-semibold block pb-2 text-sm"
                    href="privacy"
                    >Privacy Policy</Link
                  >
                </li>
                <li>
                  <Link
                    class="text-gray-700 hover:text-gray-900 font-semibold block pb-2 text-sm"
                    href="#"
                    >Contact Us</Link
                  >
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <hr class="my-6 border-gray-400" />
      <div
        class="flex flex-wrap items-center md:justify-between justify-center"
      >
        <div class="w-full md:w-4/12 px-4 mx-auto text-center">
          <div class="text-sm text-gray-600 font-semibold py-1">
            Copyright © {{date}} 
            <a
              href="https://lloydmiller.dev"
              class="text-gray-600 hover:text-gray-900"
              target="_blank"
              >Lloyd Miller</a
            >
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>
<script>
export default {
  data() {
    return {
      date: new Date().getFullYear()
    }
  }
}
</script>