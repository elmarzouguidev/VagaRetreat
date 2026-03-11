<x-app-layout>
    <div class="bg-slate-50 min-h-screen py-16" x-data="bookingForm({{ $tour->id }}, {{ $tour->accommodations->map(fn($a) => ['id' => $a->id, 'name' => $a->name, 'price' => $a->prices->first()?->amount ?? 0, 'capacity' => $a->capacity, 'price_id' => $a->prices->first()?->id])->toJson() }})">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Progress Tracker -->
            <div class="mb-12 max-w-2xl mx-auto">
                <div class="flex items-center justify-between relative">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-slate-200 -z-10 rounded-full"></div>
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-red-600 transition-all duration-500 ease-in-out -z-10 rounded-full"
                        :style="'width: ' + ((step - 1) * 50) + '%'"></div>

                    <!-- Step 1 -->
                    <div class="flex flex-col items-center group cursor-pointer" @click="step > 1 ? step = 1 : null">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold text-sm transition-all duration-300 shadow-sm border-2"
                            :class="step >= 1 ? 'bg-red-600 text-white border-red-600' : 'bg-white border-slate-300 text-slate-400 group-hover:border-slate-400'">
                            1
                        </div>
                        <span class="mt-3 text-[10px] font-black uppercase tracking-[0.2em]"
                            :class="step >= 1 ? 'text-red-600' : 'text-slate-400'">Configure</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center group cursor-pointer" @click="step > 2 ? step = 2 : null">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold text-sm transition-all duration-300 shadow-sm border-2"
                            :class="step >= 2 ? 'bg-red-600 text-white border-red-600' : 'bg-white border-slate-300 text-slate-400 group-hover:border-slate-400'">
                            2
                        </div>
                        <span class="mt-3 text-[10px] font-black uppercase tracking-[0.2em]"
                            :class="step >= 2 ? 'text-red-600' : 'text-slate-400'">Traveler</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center group">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold text-sm transition-all duration-300 shadow-sm border-2"
                            :class="step >= 3 ? 'bg-red-600 text-white border-red-600' : 'bg-white border-slate-300 text-slate-400'">
                            3
                        </div>
                        <span class="mt-3 text-[10px] font-black uppercase tracking-[0.2em]"
                            :class="step >= 3 ? 'text-red-600' : 'text-slate-400'">Checkout</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col xl:flex-row gap-12 items-start">
                
                <!-- Main Booking Interface -->
                <div class="flex-1 w-full order-2 xl:order-1">
                    <div class="bg-white rounded-[2rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                        
                        <div class="p-8 md:p-12">
                            
                            <!-- Step 1: Configuration -->
                            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0">
                                
                                <div class="mb-10 text-center md:text-left">
                                    <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-3">Begin your journey</h1>
                                    <p class="text-slate-500 font-medium">Customize your retreat preferences to see the final package cost.</p>
                                </div>

                                <!-- 1. Guest Selection -->
                                <section class="mb-12">
                                    <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">01. How many travelers?</h2>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        @foreach (['Solo Traveler' => 1, 'Two People' => 2, 'Group of Three' => 3] as $label => $val)
                                            <label class="relative group cursor-pointer">
                                                <input type="radio" x-model="form.adults_count" value="{{ $val }}" class="sr-only">
                                                <div class="flex flex-col items-center justify-center py-6 px-4 rounded-2xl border-2 transition-all duration-300"
                                                    :class="form.adults_count == {{ $val }} ? 
                                                        'border-red-600 bg-red-50/50 text-red-600 shadow-inner' : 
                                                        'border-slate-100 bg-slate-50/30 hover:border-slate-200 text-slate-500 hover:text-slate-700'">
                                                    <div class="flex -space-x-1 mb-3">
                                                        @for($i=0; $i<$val; $i++)
                                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                                                        @for($i=0; $i<$val; $i++)
                                                    </div>
                                                    <span class="text-sm font-bold uppercase tracking-tight">{{ $label }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </section>

                                <!-- 2. Accommodation -->
                                <section class="mb-12">
                                    <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">02. Select your sanctuary</h2>
                                    <div class="space-y-4">
                                        <template x-for="accom in accommodations" :key="accom.id">
                                            <label class="block relative group cursor-pointer">
                                                <input type="radio" x-model="selectedAccomId" :value="accom.id" class="sr-only">
                                                <div class="flex flex-col sm:flex-row items-center justify-between p-6 rounded-2xl border-2 transition-all duration-300 gap-4"
                                                    :class="selectedAccomId == accom.id ? 
                                                        'border-red-600 bg-red-50/30 shadow-md translate-x-1' : 
                                                        'border-slate-100 bg-slate-50/50 hover:border-slate-200'">
                                                    
                                                    <div class="flex items-center gap-5 w-full">
                                                        <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center shrink-0"
                                                            :class="selectedAccomId == accom.id ? 'border-red-600' : 'border-slate-300'">
                                                            <div x-show="selectedAccomId == accom.id" class="w-3 h-3 rounded-full bg-red-600 transition-all"></div>
                                                        </div>
                                                        <div>
                                                            <h3 class="text-lg font-bold text-slate-900" x-text="accom.name"></h3>
                                                            <div class="flex flex-wrap items-center mt-1 gap-4">
                                                                <div class="flex items-center text-xs font-bold text-slate-400 uppercase tracking-widest bg-white px-2 py-0.5 rounded border border-slate-100">
                                                                    Max <span class="mx-1" x-text="accom.capacity"></span> Guests
                                                                </div>
                                                                <template x-if="selectedAccomId == accom.id">
                                                                    <div class="flex items-center gap-1.5 text-[10px] font-black text-red-600 uppercase animate-pulse">
                                                                        <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                                                                        Recommended Selection
                                                                    </div>
                                                                </template>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="text-right w-full sm:w-auto mt-2 sm:mt-0 pt-4 sm:pt-0 border-t sm:border-t-0 border-slate-200">
                                                        <div class="text-2xl font-black text-slate-900 leading-none">$<span x-text="numberFormat(accom.price / 100)"></span></div>
                                                        <div class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">per traveler</div>
                                                    </div>
                                                </div>
                                            </label>
                                        </template>
                                    </div>
                                </section>

                                <!-- Total Panel -->
                                <div class="bg-slate-900 rounded-3xl p-8 mb-10 text-white relative overflow-hidden shadow-xl shadow-slate-900/20">
                                    <div class="absolute top-0 right-0 w-32 h-32 bg-red-600/10 blur-3xl -mr-16 -mt-16"></div>
                                    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                                        <div>
                                            <span class="text-xs font-bold text-red-400 uppercase tracking-[0.2em] block mb-2">Estimated Package Cost</span>
                                            <h3 class="text-4xl font-black tracking-tighter">$<span x-text="numberFormat(calculateTotal() / 100)"></span></h3>
                                        </div>
                                        <button @click="step = 2"
                                            class="bg-red-600 hover:bg-red-500 text-white px-10 py-5 rounded-2xl font-black uppercase tracking-widest transition-all shadow-lg active:scale-95 group flex items-center justify-center gap-3">
                                            Proceed to Traveler Info
                                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Personal Details -->
                            <div x-show="step === 2" x-cloak x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0">
                                
                                <div class="mb-10">
                                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-3">Traveler Details</h1>
                                    <p class="text-slate-500 font-medium">Please provide accurate information for the lead traveler.</p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                                    <div class="space-y-6">
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Legal First Name</label>
                                            <input type="text" x-model="form.first_name" placeholder="e.g. John"
                                                class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl py-4 px-6 focus:bg-white focus:ring-4 focus:ring-red-100 focus:border-red-600 transition-all font-bold placeholder:text-slate-300">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Email Address</label>
                                            <input type="email" x-model="form.email" placeholder="john@example.com"
                                                class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl py-4 px-6 focus:bg-white focus:ring-4 focus:ring-red-100 focus:border-red-600 transition-all font-bold placeholder:text-slate-300">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Country of Residence</label>
                                            <input type="text" x-model="form.country" placeholder="e.g. United Kingdom"
                                                class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl py-4 px-6 focus:bg-white focus:ring-4 focus:ring-red-100 focus:border-red-600 transition-all font-bold placeholder:text-slate-300">
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-6">
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Legal Last Name</label>
                                            <input type="text" x-model="form.last_name" placeholder="e.g. Doe"
                                                class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl py-4 px-6 focus:bg-white focus:ring-4 focus:ring-red-100 focus:border-red-600 transition-all font-bold placeholder:text-slate-300">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Phone Number</label>
                                            <input type="tel" x-model="form.phone" placeholder="+44 20 ..."
                                                class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl py-4 px-6 focus:bg-white focus:ring-4 focus:ring-red-100 focus:border-red-600 transition-all font-bold placeholder:text-slate-300">
                                        </div>
                                        <div class="bg-red-50/50 p-6 rounded-3xl border border-red-100">
                                            <p class="text-xs text-red-800 font-bold leading-relaxed">
                                                <svg class="w-4 h-4 inline-block mr-1 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                Identity Verification
                                            </p>
                                            <p class="text-[10px] text-red-600/70 mt-2 leading-loose uppercase tracking-wider font-medium">Your details must match your travel documents exactly to avoid issues during your retreat arrival.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col sm:flex-row justify-between items-center bg-slate-50 p-6 rounded-[2rem] gap-6">
                                    <button @click="step = 1"
                                        class="text-xs font-black text-slate-400 hover:text-slate-900 border-b-2 border-transparent hover:border-slate-900 transition-all uppercase tracking-[0.2em]">
                                        Wait, go back
                                    </button>
                                    <button @click="step = 3"
                                        class="w-full sm:w-auto bg-slate-900 text-white px-12 py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/10 active:scale-95">
                                        Verify Booking
                                    </button>
                                </div>
                            </div>

                            <!-- Step 3: Checkout -->
                            <div x-show="step === 3" x-cloak x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0">
                                
                                <div class="mb-10 text-center">
                                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-3">Finalize & confirm</h1>
                                    <p class="text-slate-500 font-medium">You are moments away from securing your spot.</p>
                                </div>

                                <div class="bg-slate-100/50 rounded-[2rem] p-10 mb-10 border-2 border-white shadow-inner">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                                        <div class="space-y-6">
                                            <div class="group">
                                                <span class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 group-hover:text-red-500 transition-colors">Retreat Identity</span>
                                                <h4 class="text-xl font-extrabold text-slate-900">{{ $tour->title }}</h4>
                                            </div>
                                            <div class="group">
                                                <span class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 group-hover:text-red-500 transition-colors">Accommodation Sanctuary</span>
                                                <h4 class="text-xl font-extrabold text-slate-900" x-text="selectedAccom?.name"></h4>
                                            </div>
                                            <div class="group">
                                                <span class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 group-hover:text-red-500 transition-colors">Party Size</span>
                                                <h4 class="text-xl font-extrabold text-slate-900"><span x-text="form.adults_count"></span> Travelers</h4>
                                            </div>
                                        </div>
                                        
                                        <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm flex flex-col justify-center text-center">
                                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-4">Final Total Owed</span>
                                            <div class="text-5xl font-black text-slate-900 tracking-tighter mb-4">$<span x-text="numberFormat(calculateTotal() / 100)"></span></div>
                                            <div class="inline-flex items-center justify-center gap-2 text-[10px] font-black text-emerald-600 uppercase bg-emerald-50 py-2 px-4 rounded-xl border border-emerald-100 self-center tracking-widest">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                                Encrypted Payment
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="max-w-xl mx-auto space-y-8">
                                    <label class="flex items-start gap-4 p-6 rounded-2xl bg-slate-50 border border-slate-100 group cursor-pointer hover:border-red-200 transition-all">
                                        <div class="relative flex items-center shrink-0">
                                            <input type="checkbox" required class="w-6 h-6 rounded-lg border-slate-300 text-red-600 focus:ring-red-500 transition-all cursor-pointer">
                                        </div>
                                        <span class="text-sm font-bold text-slate-600 leading-relaxed">
                                            I confirm all traveler details are correct and I agree to VagaRetreat's 
                                            <a href="#" class="text-red-600 border-b-2 border-red-200 hover:border-red-600 transition-all pb-0.5">Retreat Policy</a> 
                                            and <a href="#" class="text-red-600 border-b-2 border-red-200 hover:border-red-600 transition-all pb-0.5">Terms of Service</a>.
                                        </span>
                                    </label>

                                    <button @click="submitBooking()"
                                        class="relative group w-full flex items-center justify-center bg-red-600 text-white font-black py-6 rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-red-600/30 transform hover:-translate-y-1"
                                        :disabled="loading" :class="{ 'opacity-50 cursor-not-allowed': loading }">
                                        <span class="absolute w-0 h-0 transition-all duration-700 ease-out bg-white rounded-full group-hover:w-full group-hover:h-96 opacity-10"></span>
                                        <template x-if="!loading">
                                            <span class="relative text-xl tracking-[0.2em] uppercase">Confirm Journey</span>
                                        </template>
                                        <template x-if="loading">
                                            <span class="relative flex items-center uppercase tracking-widest text-lg">
                                                <svg class="animate-spin -ml-1 mr-3 h-6 w-6 text-white" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                Securing Spot...
                                            </span>
                                        </template>
                                    </button>
                                    
                                    <button @click="step = 2" :disabled="loading"
                                        class="w-full text-xs font-black text-slate-400 hover:text-slate-900 transition-all uppercase tracking-[0.2em]">
                                        Back to details
                                    </button>
                                </div>
                            </div>

                            <!-- Success Celebration -->
                            <div x-show="step === 4" x-cloak style="display: none;" class="text-center py-24 max-w-lg mx-auto"
                                x-transition:enter="transition ease-out duration-1000"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100">
                                
                                <div class="relative inline-block mb-10">
                                    <div class="absolute inset-0 bg-emerald-100 rounded-full blur-3xl opacity-50 animate-pulse"></div>
                                    <div class="relative w-32 h-32 bg-emerald-500 rounded-full flex items-center justify-center mx-auto shadow-2xl shadow-emerald-500/40">
                                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </div>
                                
                                <h2 class="text-4xl font-black text-slate-900 mb-6 tracking-tight uppercase">Journey Secured!</h2>
                                <p class="text-slate-600 font-medium mb-12 text-lg">Your booking reference is <span class="bg-slate-900 text-white px-3 py-1.5 rounded-xl font-black mx-1 tracking-wider" x-text="bookingReference"></span>. Confirmation details have been sent to your email.</p>
                                
                                <div class="flex flex-col gap-4">
                                    <a href="{{ route('home') }}"
                                        class="bg-slate-900 text-white px-10 py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-black transition-all shadow-xl active:scale-95 block">
                                        Return to Exploration
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Contextual Support -->
                <div class="xl:w-[400px] w-full order-1 xl:order-2">
                    <div class="sticky top-28 space-y-8">
                        
                        <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-xl shadow-slate-200/40">
                            <h3 class="text-[10px] font-black text-red-600 uppercase tracking-[0.2em] mb-8 flex items-center">
                                <span class="w-8 h-px bg-red-600/20 mr-3"></span>
                                Why Book Direct?
                            </h3>
                            
                            <ul class="space-y-8">
                                <li class="flex items-start">
                                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div class="ml-5">
                                        <h4 class="text-sm font-bold text-slate-900 mb-1">No Immediate Charges</h4>
                                        <p class="text-xs text-slate-500 font-medium leading-relaxed">Secure your reservation today. You only pay when the retreat minimum group size is confirmed.</p>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    </div>
                                    <div class="ml-5">
                                        <h4 class="text-sm font-bold text-slate-900 mb-1">Guaranteed Service</h4>
                                        <p class="text-xs text-slate-500 font-medium leading-relaxed">Our price match guarantee ensures you get the most premium experience at the best possible value.</p>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <div class="w-10 h-10 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div class="ml-5">
                                        <h4 class="text-sm font-bold text-slate-900 mb-1">30-Day Cancellation</h4>
                                        <p class="text-xs text-slate-500 font-medium leading-relaxed">Plans change. Enjoy full flexibility with our industry-leading retreat cancellation policy.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="flex flex-col gap-4 bg-slate-900 rounded-[2rem] p-8 text-white relative overflow-hidden group">
                            <div class="absolute top-0 left-0 w-full h-full bg-red-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-in-out -z-10 opacity-10"></div>
                            <h4 class="text-xs font-black text-red-500 uppercase tracking-widest mb-2">Need Assistance?</h4>
                            <p class="text-xs text-slate-400 font-medium leading-relaxed mb-6">Our travel specialists are available 24/7 to help you coordinate your perfect retreat experience.</p>
                            
                            <a href="#" class="flex items-center justify-center gap-3 py-4 rounded-2xl bg-white/5 border border-white/10 text-white font-black uppercase text-[10px] tracking-widest hover:bg-white hover:text-slate-900 transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                                Contact Concierge
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('bookingForm', (tourId, accommodations) => ({
                    step: 1,
                    loading: false,
                    bookingReference: '',
                    accommodations: accommodations,
                    selectedAccomId: accommodations[0]?.id,

                    get selectedAccom() {
                        return this.accommodations.find(a => a.id == this.selectedAccomId);
                    },

                    form: {
                        tour_package_id: tourId,
                        start_date: new Date().toISOString().split('T')[0],
                        adults_count: 1,
                        children_count: 0,
                        first_name: '',
                        last_name: '',
                        email: '',
                        phone: '',
                        country: '',
                        special_requests: ''
                    },

                    calculateTotal() {
                        if (!this.selectedAccom) return 0;
                        return this.form.adults_count * this.selectedAccom.price;
                    },

                    numberFormat(val) {
                        return new Intl.NumberFormat('en-US', {
                            minimumFractionDigits: 0
                        }).format(val);
                    },

                    async submitBooking() {
                        const priceId = this.selectedAccom?.price_id;
                        if (!priceId) {
                            alert('Price calculation error. Please select an accommodation.');
                            return;
                        }

                        this.loading = true;

                        const payload = {
                            bookable_type: 'App\\Models\\Tour\\TourPackage',
                            bookable_id: this.form.tour_package_id,
                            price_id: priceId,
                            booking_date: this.form.start_date,
                            customer_name: `${this.form.first_name} ${this.form.last_name}`.trim(),
                            customer_email: this.form.email,
                            customer_phone: this.form.phone,
                            customer_country: this.form.country,
                            adults_count: this.form.adults_count,
                            children_count: this.form.children_count,
                            accommodation_id: this.selectedAccomId 
                        };

                        try {
                            const response = await fetch('/bookings', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify(payload)
                            });

                            const data = await response.json();

                            if (response.ok) {
                                this.bookingReference = data.booking.booking_reference;
                                this.step = 4;
                                window.scrollTo({ top: 0, behavior: 'smooth' });
                            } else {
                                let msg = data.message || 'Unknown error';
                                if (data.errors) {
                                    msg += '\n' + Object.values(data.errors).flat().join('\n');
                                }
                                alert('Booking failed: ' + msg);
                            }
                        } catch (error) {
                            alert('An error occurred. Please try again.');
                        } finally {
                            this.loading = false;
                        }
                    }
                }));
            });
        </script>
    @endpush
</x-app-layout>
