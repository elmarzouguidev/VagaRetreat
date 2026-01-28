<x-app-layout>
    <div class="bg-white min-h-screen py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                
                <!-- Left: Contact Info -->
                <div class="space-y-12">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tighter uppercase mb-6">
                            Let's Connect<span class="text-elmarzouguidev-vaga-red">.</span>
                        </h1>
                        <p class="text-xl text-gray-600 max-w-md leading-relaxed">
                            Have questions about our retreats or need help planning your next mindful adventure? Our team is here for you.
                        </p>
                    </div>

                    <div class="space-y-8">
                        <div class="flex items-start">
                            <div class="bg-gray-50 p-4 rounded-2xl mr-6">
                                <svg class="w-6 h-6 text-elmarzouguidev-vaga-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Email Us</h3>
                                <p class="text-lg font-bold text-gray-900">contact@vagaretreat.com</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-gray-50 p-4 rounded-2xl mr-6">
                                <svg class="w-6 h-6 text-elmarzouguidev-vaga-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Visit Us</h3>
                                <p class="text-lg font-bold text-gray-900">Marrakech, Morocco</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Contact Form -->
                <div class="bg-gray-50 p-8 md:p-12 rounded-[2.5rem] shadow-sm border border-gray-100">
                    @if(session('success'))
                        <div class="mb-8 p-6 bg-white border-l-4 border-green-500 rounded-2xl shadow-sm flex items-center">
                            <svg class="w-6 h-6 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-green-800 font-bold uppercase text-xs tracking-widest">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('contact.post') }}" method="POST" class="space-y-8">
                        @csrf
                        
                        <div class="space-y-2">
                            <label for="name" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Full Name</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   required
                                   placeholder="Your Name"
                                   class="w-full bg-white border-2 border-transparent focus:border-elmarzouguidev-vaga-red focus:ring-0 rounded-2xl p-5 text-gray-900 font-bold placeholder-gray-300 transition-all">
                            @error('name') <p class="text-[10px] font-bold text-red-500 uppercase tracking-widest ml-1 mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Email Address</label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}"
                                   required
                                   placeholder="hello@example.com"
                                   class="w-full bg-white border-2 border-transparent focus:border-elmarzouguidev-vaga-red focus:ring-0 rounded-2xl p-5 text-gray-900 font-bold placeholder-gray-300 transition-all">
                            @error('email') <p class="text-[10px] font-bold text-red-500 uppercase tracking-widest ml-1 mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="message" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Your Message</label>
                            <textarea name="message" 
                                      id="message" 
                                      rows="5" 
                                      required
                                      placeholder="Tell us about your next adventure..."
                                      class="w-full bg-white border-2 border-transparent focus:border-elmarzouguidev-vaga-red focus:ring-0 rounded-2xl p-5 text-gray-900 font-bold placeholder-gray-300 transition-all">{{ old('message') }}</textarea>
                            @error('message') <p class="text-[10px] font-bold text-red-500 uppercase tracking-widest ml-1 mt-2">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" 
                                class="w-full bg-elmarzouguidev-vaga-red text-white py-6 rounded-2xl text-xs font-black uppercase tracking-[0.3em] hover:bg-red-700 transition-all shadow-xl hover:shadow-red-200/50 flex items-center justify-center group">
                            Send Message
                            <svg class="w-4 h-4 ml-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
