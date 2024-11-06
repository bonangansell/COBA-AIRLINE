<nav class="bg-white border-gray-200 dark:bg-gray-800 dark:border-gray-700">
  <div class="flex justify-between items-center p-8">     
      <h2 class="text-center text-white text-3xl font-bold flex-1 ml-28">Airplane Booking System</h2>
      
      @auth
        <!-- Tombol Logout -->
        <form method="POST" action="/logout" class="flex items-center">
          @csrf
          <button type="submit" class="flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
              <!-- Ikon Logout -->
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3m14-4V4a2 2 0 00-2-2H5a2 2 0 00-2 2v16a2 2 0 002 2h10a2 2 0 002-2v-4" />
              </svg>
              Logout
          </button>
        </form>
    @else
      
    @endauth
    
  </nav>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const navItems = document.querySelectorAll('#navbar-dropdown a');
  
      // Add a click event listener to each nav item
      navItems.forEach(item => {
        item.addEventListener('click', function() {
          // Remove active classes from all items
          navItems.forEach(nav => {
            nav.classList.remove('text-white', 'bg-blue-700', 'dark:bg-blue-600', 'md:text-blue-700', 'md:dark:text-blue-500');
            nav.classList.add('text-gray-900', 'dark:text-white');
          });
  
          // Add active classes to the clicked item
          this.classList.remove('text-gray-900', 'dark:text-white');
          this.classList.add('text-white', 'bg-blue-700', 'dark:bg-blue-600', 'md:text-blue-700', 'md:dark:text-blue-500');
        });
      });
    });
  </script>
  