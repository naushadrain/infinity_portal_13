<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Satisfaction Form</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800">

    <header class="bg-white shadow-sm">
        <!-- Top Contact Bar -->
        <div
            class="max-w-7xl mx-auto px-4 py-6 flex items-start justify-start gap-10 text-sm font-semibold text-slate-800">
            <span class="flex items-center gap-2">
                <i data-lucide="mail" class="w-5 h-5 text-sky-500"></i>
                info@infiniteability.com.au
            </span>

            <span class="flex items-center gap-2">
                <i data-lucide="phone" class="w-5 h-5 text-sky-500"></i>
                1300044422
            </span>
        </div>

        <!-- Logo + Navigation -->
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <div>
                <img src="https://infiniteability.com.au/wp-content/uploads/2024/10/logo-ndis.png" class="h-14"
                    alt="Infinite Ability Logo">
            </div>

            <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                <a href="#" class="hover:text-sky-600">About Us</a>
                <a href="#" class="hover:text-sky-600">Services</a>
                <a href="#" class="hover:text-sky-600">About NDIS</a>
                <a href="#" class="text-lime-500">Referral</a>
                <a href="#" class="hover:text-sky-600">Gallery</a>
                <a href="#" class="hover:text-sky-600">Contact Us</a>
            </nav>
        </div>
    </header>

    <section class="relative h-[450px] flex items-center justify-center overflow-hidden">

        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="https://infiniteability.com.au/wp-content/uploads/2024/10/4.jpg" alt="Customer Satisfaction"
                class="w-full h-full object-cover">
        </div>

        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black/50"></div>

        <!-- Content -->
        <div class="relative z-10 text-center px-4">
            <h1 class="text-white text-4xl md:text-6xl font-bold">
                Customer Satisfaction Form
            </h1>
            <p class="text-white/90 mt-4 text-lg">
                We want to hear from our customers
            </p>
        </div>

    </section>

    <main class="max-w-5xl mx-auto px-4 py-10">
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 md:p-10">

            <h2 class="text-2xl font-bold mb-2">
                We want to hear from our Customer!
            </h2>
            <p class="text-slate-500 mb-8">
                Please share your honest responses to the following questions.
            </p>

            <form method="POST" action="{{ route('customer-satisfy-victoria.store') }}" class="space-y-8">
                @csrf

                <!-- Hidden city_name field - passes "Perth" without displaying -->
                <input type="hidden" name="city_name" value="Victoria">

                <!-- OR use this if you want to display it but hide with CSS -->
                <!-- <input type="text" name="city_name" value="Perth" class="hidden"> -->
                <!-- OR use Tailwind display-none -->
                <!-- <input type="text" name="city_name" value="Perth" class="display-none"> -->

                <div>
                    <label class="block font-semibold mb-3">
                        1. How satisfied were you overall with the service provided by Infinite Ability?
                    </label>
                    <div class="space-y-2">
                        <label class="flex gap-2">
                            <input type="radio" name="overall_satisfy" value="4" required> Very satisfied
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="overall_satisfy" value="3"> Satisfied
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="overall_satisfy" value="2"> Neutral
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="overall_satisfy" value="1"> Unsatisfied
                        </label>
                    </div>
                    @error('overall_satisfy')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-3">
                        2. Overall, how professionally do our employees behave?
                    </label>
                    <div class="space-y-2">
                        <label class="flex gap-2">
                            <input type="radio" name="employee_behave" value="4" required> Excellent
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="employee_behave" value="3"> Good
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="employee_behave" value="2"> Average
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="employee_behave" value="1"> Poor
                        </label>
                    </div>
                    @error('employee_behave')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-3">
                        3. How effective is Infinite Ability at resolving your concerns?
                    </label>
                    <div class="space-y-2">
                        <label class="flex gap-2">
                            <input type="radio" name="resolving_ability" value="4" required> Very effective
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="resolving_ability" value="3"> Effective
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="resolving_ability" value="2"> Neutral
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="resolving_ability" value="1"> Not effective
                        </label>
                    </div>
                    @error('resolving_ability')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-3">
                        4. How do you rate the staff for their willingness to help you?
                    </label>
                    <div class="space-y-2">
                        <label class="flex gap-2">
                            <input type="radio" name="staff_will" value="4" required> Excellent
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="staff_will" value="3"> Good
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="staff_will" value="2"> Average
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="staff_will" value="1"> Poor
                        </label>
                    </div>
                    @error('staff_will')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-3">
                        5. How well do our employees explain information to you?
                    </label>
                    <div class="space-y-2">
                        <label class="flex gap-2">
                            <input type="radio" name="employees_explain" value="4" required> Very clearly
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="employees_explain" value="3"> Clearly
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="employees_explain" value="2"> Somewhat clearly
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="employees_explain" value="1"> Not clearly
                        </label>
                    </div>
                    @error('employees_explain')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-3">
                        6. How would you rate the quality of our services?
                    </label>
                    <div class="space-y-2">
                        <label class="flex gap-2">
                            <input type="radio" name="rate_quality" value="4" required> Excellent
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="rate_quality" value="3"> Good
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="rate_quality" value="2"> Average
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="rate_quality" value="1"> Poor
                        </label>
                    </div>
                    @error('rate_quality')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-3">
                        7. How likely are you to recommend Infinite Ability to a friend or colleague?
                    </label>
                    <div class="space-y-2">
                        <label class="flex gap-2">
                            <input type="radio" name="like_recommend" value="4" required> Very likely
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="like_recommend" value="3"> Likely
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="like_recommend" value="2"> Not sure
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="like_recommend" value="1"> Unlikely
                        </label>
                    </div>
                    @error('like_recommend')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-3">
                        8. Overall, how well does Infinite Ability meet your needs?
                    </label>
                    <div class="space-y-2">
                        <label class="flex gap-2">
                            <input type="radio" name="meet_needs" value="4" required> Very well
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="meet_needs" value="3"> Well
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="meet_needs" value="2"> Average
                        </label>
                        <label class="flex gap-2">
                            <input type="radio" name="meet_needs" value="1"> Poor
                        </label>
                    </div>
                    @error('meet_needs')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-3">
                        9. Do you have any other comments, suggestions, or concerns?
                    </label>
                    <textarea name="suggestions" rows="5"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter here"></textarea>
                    @error('suggestions')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold">
                    Submit
                </button>
            </form>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mt-4">
                    <p class="text-green-800 font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mt-4">
                    <h3 class="font-semibold text-red-800 mb-2">Please fix the errors:</h3>
                    <ul class="list-disc list-inside text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </main>

    <footer class="bg-slate-900 text-white mt-10">
        <div class="max-w-7xl mx-auto px-4 py-10 grid md:grid-cols-4 gap-8">
            <div>
                <img src="https://infiniteability.com.au/wp-content/uploads/2024/10/logo-ndis.png"
                    class="h-14 bg-white rounded p-1 mb-4" alt="Logo">
                <p class="text-sm text-slate-300">
                    Infinite Ability customer support and service feedback form.
                </p>
            </div>

            <div>
                <h3 class="font-bold mb-3">Quick Links</h3>
                <ul class="space-y-2 text-sm text-slate-300">
                    <li>Home</li>
                    <li>About Us</li>
                    <li>About NDIS</li>
                </ul>
            </div>

            <div>
                <h3 class="font-bold mb-3">Services</h3>
                <ul class="space-y-2 text-sm text-slate-300">
                    <li>Supported Independent Living</li>
                    <li>NDIS Support Coordination</li>
                    <li>Personal Care</li>
                </ul>
            </div>

            <div>
                <h3 class="font-bold mb-3">Contact</h3>
                <p class="text-sm text-slate-300">info@infiniteability.com.au</p>
                <p class="text-sm text-slate-300">1300044422</p>
            </div>
        </div>

        <div class="border-t border-slate-700 py-4 text-center text-sm text-slate-400">
            Copyright © 2026 Infinite Ability. All rights reserved.
        </div>
    </footer>

</body>

</html>
