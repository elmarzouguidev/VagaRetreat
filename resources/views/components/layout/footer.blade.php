<footer class="bg-white border-t border-gray-100 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <!-- Brand -->
            <div class="col-span-1 md:col-span-1">
                <span class="text-2xl font-bold tracking-tighter text-elmarzouguidev-vaga-black mb-6 block">
                    VagaRetreat<span class="text-elmarzouguidev-vaga-red">.</span>
                </span>
                <p class="text-gray-500 text-sm leading-relaxed mb-6">
                    Discover and book unique retreats, workshops, and training courses led by world-class instructors.
                </p>
                <div class="flex space-x-4">
                    <!-- Social icons placeholders -->
                    <a href="#" class="text-gray-400 hover:text-elmarzouguidev-vaga-red transition"><span class="sr-only">Facebook</span><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                    <a href="#" class="text-gray-400 hover:text-elmarzouguidev-vaga-red transition"><span class="sr-only">Twitter</span><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg></a>
                </div>
            </div>

            <!-- Links Column 1 -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">Company</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('cms.pages.show', 'about-us') }}" class="text-sm text-gray-600 hover:text-elmarzouguidev-vaga-red transition">About Us</a></li>
                    <li><a href="#" class="text-sm text-gray-600 hover:text-elmarzouguidev-vaga-red transition">Careers</a></li>
                    <li><a href="#" class="text-sm text-gray-600 hover:text-elmarzouguidev-vaga-red transition">Press</a></li>
                    <li><a href="{{ route('blog.index') }}" class="text-sm text-gray-600 hover:text-elmarzouguidev-vaga-red transition">Blog</a></li>
                </ul>
            </div>

            <!-- Links Column 2 -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">Support</h3>
                <ul class="space-y-3">
                    <li><a href="#" class="text-sm text-gray-600 hover:text-elmarzouguidev-vaga-red transition">Help Center</a></li>
                    <li><a href="#" class="text-sm text-gray-600 hover:text-elmarzouguidev-vaga-red transition">Safety Information</a></li>
                    <li><a href="#" class="text-sm text-gray-600 hover:text-elmarzouguidev-vaga-red transition">Cancellation Options</a></li>
                    <li><a href="{{ route('contact.index') }}" class="text-sm text-gray-600 hover:text-elmarzouguidev-vaga-red transition">Contact Us</a></li>
                </ul>
            </div>

             <!-- Links Column 3 -->
             <div>
                <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">Legal</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('cms.pages.show', 'privacy-policy') }}" class="text-sm text-gray-600 hover:text-elmarzouguidev-vaga-red transition">Privacy Policy</a></li>
                    <li><a href="{{ route('cms.pages.show', 'terms-and-conditions') }}" class="text-sm text-gray-600 hover:text-elmarzouguidev-vaga-red transition">Terms of Service</a></li>
                    <li><a href="#" class="text-sm text-gray-600 hover:text-elmarzouguidev-vaga-red transition">Cookie Policy</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-sm text-gray-400">
                &copy; {{ date('Y') }} VagaRetreat, Inc. All rights reserved.
            </p>
        </div>
    </div>
</footer>
