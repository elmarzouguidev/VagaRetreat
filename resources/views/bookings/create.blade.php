<x-app-layout>
    <div class="container-fluid">
    <div class="bg-gray-50 min-h-screen py-12" 
         x-data="bookingForm({{ $tour->id }}, {{ $tour->accommodations->map(fn($a) => ['id' => $a->id, 'name' => $a->name, 'price' => $a->prices->first()?->amount ?? 0, 'capacity' => $a->capacity, 'price_id' => $a->prices->first()?->id])->toJson() }})">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-between relative">
                    <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 -z-10"></div>
                    <div class="absolute left-0 top-1/2 transform -translate-y-1/2 h-1 bg-elmarzouguidev-vaga-red transition-all duration-300 -z-10" :style="'width: ' + ((step - 1) * 50) + '%'"></div>
                    
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center cursor-pointer" @click="step > 1 ? step = 1 : null">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300 shadow-sm" 
                             :class="step >= 1 ? 'bg-elmarzouguidev-vaga-red text-white' : 'bg-white border border-gray-300 text-gray-400'">
                            1
                        </div>
                        <span class="mt-2 text-xs font-bold uppercase tracking-wider" :class="step >= 1 ? 'text-elmarzouguidev-vaga-red' : 'text-gray-400'">Details</span>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="flex flex-col items-center cursor-pointer" @click="step > 2 ? step = 2 : null">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300 shadow-sm"
                             :class="step >= 2 ? 'bg-elmarzouguidev-vaga-red text-white' : 'bg-white border border-gray-300 text-gray-400'">
                            2
                        </div>
                        <span class="mt-2 text-xs font-bold uppercase tracking-wider" :class="step >= 2 ? 'text-elmarzouguidev-vaga-red' : 'text-gray-400'">Personal</span>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                         <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300 shadow-sm"
                             :class="step >= 3 ? 'bg-elmarzouguidev-vaga-red text-white' : 'bg-white border border-gray-300 text-gray-400'">
                            3
                        </div>
                        <span class="mt-2 text-xs font-bold uppercase tracking-wider" :class="step >= 3 ? 'text-elmarzouguidev-vaga-red' : 'text-gray-400'">Confirm</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Column: Form -->
                <div class="flex-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="p-8">
                            <!-- Step 1: Dates & Guests -->
                            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                                <h1 class="text-2xl font-black text-elmarzouguidev-vaga-red mb-8 uppercase tracking-tight">Book this retreat</h1>
                                
                                <!-- 1. Select number of guests -->
                                <section class="mb-10">
                                    <h2 class="text-sm font-bold text-gray-900 mb-4 tracking-tight">1. Select number of guests</h2>
                                    <div class="flex flex-wrap gap-4">
                                        @foreach(['One guest' => 1, 'Two guests' => 2, 'Three guests' => 3] as $label => $val)
                                            <label class="relative flex-1 min-w-[120px] group cursor-pointer">
                                                <input type="radio" x-model="form.adults_count" value="{{ $val }}" class="sr-only">
                                                <div class="flex items-center justify-center space-x-2 py-3 px-4 rounded-lg border-2 transition-all duration-200"
                                                     :class="form.adults_count == {{ $val }} ? 'border-elmarzouguidev-vaga-red bg-red-50 text-elmarzouguidev-vaga-red' : 'border-gray-100 hover:border-gray-200 text-gray-600 bg-white'">
                                                    <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center" :class="form.adults_count == {{ $val }} ? 'border-elmarzouguidev-vaga-red' : 'border-gray-300'">
                                                        <div x-show="form.adults_count == {{ $val }}" class="w-1.5 h-1.5 rounded-full bg-elmarzouguidev-vaga-red"></div>
                                                    </div>
                                                    <span class="text-sm font-bold">{{ $label }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </section>

                                <!-- 2. Select Accommodation -->
                                <section class="mb-10">
                                    <h2 class="text-sm font-bold text-gray-900 mb-4 tracking-tight">2. Select Accommodation</h2>
                                    <div class="space-y-4">
                                        <template x-for="accom in accommodations" :key="accom.id">
                                            <label class="block relative group cursor-pointer">
                                                <input type="radio" x-model="selectedAccomId" :value="accom.id" class="sr-only">
                                                <div class="flex items-center justify-between p-5 rounded-xl border-2 transition-all duration-200"
                                                     :class="selectedAccomId == accom.id ? 'border-elmarzouguidev-vaga-red bg-red-50' : 'border-gray-100 hover:border-gray-200 bg-white'">
                                                    <div class="flex items-center space-x-4">
                                                        <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center" :class="selectedAccomId == accom.id ? 'border-elmarzouguidev-vaga-red' : 'border-gray-300'">
                                                            <div x-show="selectedAccomId == accom.id" class="w-2.5 h-2.5 rounded-full bg-elmarzouguidev-vaga-red"></div>
                                                        </div>
                                                        <div>
                                                            <div class="text-base font-bold text-gray-900" x-text="accom.name"></div>
                                                            <div class="flex items-center mt-1 space-x-3">
                                                                <span class="text-xs font-medium text-gray-500 flex items-center">
                                                                    Room Capacity: <span class="ml-1 flex">
                                                                        <template x-for="i in parseInt(accom.capacity)">
                                                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
                                                                        </template>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <div class="text-xl font-black text-gray-900">$<span x-text="numberFormat(accom.price / 100)"></span></div>
                                                        <template x-if="selectedAccomId == accom.id">
                                                            <div class="text-[10px] font-bold text-elmarzouguidev-vaga-red mt-1 uppercase">Only few spots left!</div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </label>
                                        </template>
                                    </div>
                                </section>

                                <!-- 3. Select payment method -->
                                <section class="mb-10">
                                    <h2 class="text-sm font-bold text-gray-900 mb-4 tracking-tight">3. Select payment method</h2>
                                    <label class="block relative group cursor-pointer">
                                        <input type="radio" checked class="sr-only">
                                        <div class="flex items-center p-5 rounded-xl border-2 border-elmarzouguidev-vaga-red bg-red-50">
                                            <div class="w-5 h-5 rounded-full border-2 border-elmarzouguidev-vaga-red flex items-center justify-center mr-4">
                                                <div class="w-2.5 h-2.5 rounded-full bg-elmarzouguidev-vaga-red"></div>
                                            </div>
                                            <div class="flex items-center space-x-4">
                                                <svg class="w-10 h-10 text-gray-800" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"></path></svg>
                                                <div>
                                                    <div class="text-base font-bold text-gray-900">Credit Card</div>
                                                    <div class="text-[11px] font-medium text-gray-500 uppercase">Visa, MasterCard, Amex</div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </section>

                                <!-- Summary Section -->
                                <section class="bg-gray-50 rounded-xl p-8 border border-gray-100">
                                    <h2 class="text-sm font-bold text-gray-900 mb-6 tracking-tight uppercase">Your Summary:</h2>
                                    <div class="space-y-4">
                                        <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                                            <span class="text-gray-900 font-bold" x-text="selectedAccom?.name || 'Selected accommodation'"></span>
                                            <span class="text-sm font-medium text-gray-600">Price per guest: <span class="font-bold text-gray-900">$<span x-text="numberFormat((selectedAccom?.price || 0) / 100)"></span></span></span>
                                        </div>
                                        <div class="flex justify-between items-center pt-2">
                                            <span class="text-lg font-black text-gray-900 uppercase">Total amount:</span>
                                            <span class="text-3xl font-black text-elmarzouguidev-vaga-red">$<span x-text="numberFormat(calculateTotal() / 100)"></span></span>
                                        </div>
                                    </div>
                                </section>

                                <div class="mt-10 flex justify-end">
                                    <button @click="step = 2" class="bg-elmarzouguidev-vaga-red text-white w-full py-4 rounded-xl font-black uppercase tracking-widest hover:bg-red-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 active:translate-y-0">
                                        Next Step
                                    </button>
                                </div>
                            </div>

                            <!-- Step 2: Personal Details -->
                            <div x-show="step === 2" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                                <h1 class="text-2xl font-black text-elmarzouguidev-vaga-red mb-8 uppercase tracking-tight">Your Information</h1>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">First Name</label>
                                        <input type="text" x-model="form.first_name" class="w-full rounded-xl border-gray-200 py-4 focus:ring-elmarzouguidev-vaga-red focus:border-elmarzouguidev-vaga-red transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Last Name</label>
                                        <input type="text" x-model="form.last_name" class="w-full rounded-xl border-gray-200 py-4 focus:ring-elmarzouguidev-vaga-red focus:border-elmarzouguidev-vaga-red transition-all">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Email Address</label>
                                        <input type="email" x-model="form.email" class="w-full rounded-xl border-gray-200 py-4 focus:ring-elmarzouguidev-vaga-red focus:border-elmarzouguidev-vaga-red transition-all">
                                    </div>
                                     <div class="md:col-span-2">
                                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Phone Number</label>
                                        <input type="tel" x-model="form.phone" class="w-full rounded-xl border-gray-200 py-4 focus:ring-elmarzouguidev-vaga-red focus:border-elmarzouguidev-vaga-red transition-all">
                                    </div>
                                     <div class="md:col-span-2">
                                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Country</label>
                                        <input type="text" x-model="form.country" class="w-full rounded-xl border-gray-200 py-4 focus:ring-elmarzouguidev-vaga-red focus:border-elmarzouguidev-vaga-red transition-all">
                                    </div>
                                </div>

                                <div class="mt-10 flex justify-between items-center">
                                    <button @click="step = 1" class="text-sm font-bold text-gray-400 hover:text-gray-900 border-b-2 border-transparent hover:border-gray-900 transition-all uppercase tracking-widest">
                                        Back
                                    </button>
                                    <button @click="step = 3" class="bg-elmarzouguidev-vaga-red text-white px-10 py-4 rounded-xl font-black uppercase tracking-widest hover:bg-red-700 transition-all shadow-lg active:scale-95">
                                        Review booking
                                    </button>
                                </div>
                            </div>

                            <!-- Step 3: Confirmation -->
                            <div x-show="step === 3" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                                <h1 class="text-2xl font-black text-elmarzouguidev-vaga-red mb-8 uppercase tracking-tight">Review & Confirm</h1>
                                
                                <div class="bg-gray-900 rounded-xl p-8 mb-8 text-white">
                                    <div class="space-y-4">
                                        <div class="flex justify-between border-b border-gray-800 pb-4">
                                            <span class="text-gray-400 font-bold uppercase text-[11px] tracking-widest">Retreat</span>
                                            <span class="font-bold">{{ $tour->title }}</span>
                                        </div>
                                        <div class="flex justify-between border-b border-gray-800 pb-4">
                                            <span class="text-gray-400 font-bold uppercase text-[11px] tracking-widest">Accommodation</span>
                                            <span class="font-bold" x-text="selectedAccom?.name"></span>
                                        </div>
                                        <div class="flex justify-between border-b border-gray-800 pb-4">
                                            <span class="text-gray-400 font-bold uppercase text-[11px] tracking-widest">Guests</span>
                                            <span class="font-bold"><span x-text="form.adults_count"></span> Adults</span>
                                        </div>
                                        <div class="flex justify-between pt-2">
                                            <span class="text-elmarzouguidev-vaga-red font-black uppercase text-lg">Total Amount</span>
                                            <span class="text-2xl font-black">$<span x-text="numberFormat(calculateTotal() / 100)"></span></span>
                                        </div>
                                    </div>
                                </div>

                                <label class="flex items-start mb-8 group cursor-pointer">
                                    <input type="checkbox" class="mt-1 rounded border-gray-300 text-elmarzouguidev-vaga-red focus:ring-elmarzouguidev-vaga-red h-5 w-5 transition-all">
                                    <span class="ml-4 text-sm font-medium text-gray-600 leading-relaxed">I agree to the <a href="#" class="text-elmarzouguidev-vaga-red border-b border-elmarzouguidev-vaga-red hover:bg-red-50 transition-all font-bold">Terms & Conditions</a> and <a href="#" class="text-elmarzouguidev-vaga-red border-b border-elmarzouguidev-vaga-red hover:bg-red-50 transition-all font-bold">Privacy Policy</a>.</span>
                                </label>

                                <div class="flex justify-between items-center">
                                    <button @click="step = 2" class="text-sm font-bold text-gray-400 hover:text-gray-900 transition-all uppercase tracking-widest">
                                        Back
                                    </button>
                                    <button @click="submitBooking()" class="bg-elmarzouguidev-vaga-red text-white px-12 py-5 rounded-xl font-black uppercase tracking-widest hover:bg-red-700 transition-all shadow-xl active:scale-95" :disabled="loading" :class="{'opacity-50 cursor-not-allowed': loading}">
                                        <span x-show="!loading">Finalize Booking</span>
                                        <span x-show="loading" class="flex items-center">
                                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                            Processing...
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <!-- Success Message -->
                             <div x-show="step === 4" style="display: none;" class="text-center py-20">
                                <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <h2 class="text-3xl font-black text-gray-900 mb-4 uppercase tracking-tighter">You're going to Morocco!</h2>
                                <p class="text-lg text-gray-600 mb-10">Booking Reference: <span class="bg-gray-100 px-3 py-1 rounded font-black text-gray-900 ml-1" x-text="bookingReference"></span></p>
                                <a href="{{ route('home') }}" class="inline-block bg-gray-900 text-white px-10 py-4 rounded-xl font-black uppercase tracking-widest hover:bg-black transition-all shadow-lg active:scale-95">Go to my dashboard</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Info -->
                <div class="lg:w-[400px]">
                    <div class="sticky top-8 space-y-8">
                        <div>
                            <h3 class="text-sm font-black text-elmarzouguidev-vaga-red uppercase tracking-widest mb-6">Booking information</h3>
                            <ul class="space-y-6">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-elmarzouguidev-vaga-red mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                    <span class="ml-4 text-sm font-bold text-gray-900 tracking-tight">All prices are in US dollars</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-elmarzouguidev-vaga-red mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                    <div class="ml-4">
                                        <span class="block text-sm font-bold text-gray-900 tracking-tight mb-2">You will not be charged until this retreat becomes guaranteed.</span>
                                        <p class="text-xs text-gray-500 leading-relaxed font-medium">Your payment method will not be charged at this time. The final amount will be charged once the retreat becomes guaranteed. We will get in touch 48 hours before charging your payment method.</p>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-elmarzouguidev-vaga-red mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                    <div class="ml-4">
                                        <span class="block text-sm font-bold text-gray-900 tracking-tight mb-2">With guaranteed retreats:</span>
                                        <ul class="space-y-2">
                                            <li class="flex items-center text-xs text-gray-500 font-bold uppercase tracking-tighter">
                                                <svg class="w-3 h-3 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                                                There is no cancellation
                                            </li>
                                            <li class="flex items-center text-xs text-gray-500 font-bold uppercase tracking-tighter">
                                                <svg class="w-3 h-3 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                                                Minimum group size has been met
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="flex flex-col gap-3">
                            <button class="flex items-center justify-center space-x-3 py-3 px-6 rounded-xl border-2 border-gray-900 text-gray-900 font-black uppercase text-[11px] tracking-widest hover:bg-gray-50 transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"></path></svg>
                                <span>Contact Us</span>
                            </button>
                            <button class="flex items-center justify-center space-x-3 py-3 px-6 rounded-xl border-2 border-gray-900 text-gray-900 font-black uppercase text-[11px] tracking-widest hover:bg-gray-50 transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12c0 1.54.36 2.98.97 4.29L1 23l6.89-1.91A9.94 9.94 0 0012 22c5.52 0 10-4.48 10-10S17.52 2 12 2z"></path></svg>
                                <span>Quick Question</span>
                            </button>
                        </div>
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
                    return new Intl.NumberFormat('en-US', { minimumFractionDigits: 0 }).format(val);
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
                        accommodation_id: this.selectedAccomId // Optional but good for posterity
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
