<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback, Compliments & Complaints</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body{
            background:#f5f7fa;
        }

        .form-container{
            max-width:1000px;
            margin:40px auto;
        }

        .card{
            border:none;
            border-radius:12px;
            box-shadow:0 5px 20px rgba(0,0,0,.08);
        }

        .card-header{
            background:#0d6efd;
            color:#fff;
            padding:20px;
            border-radius:12px 12px 0 0 !important;
        }

        textarea{
            resize:none;
        }

        .section-title{
            color:#0d6efd;
            font-weight:600;
            margin-bottom:15px;
        }

        .info-box{
            background:#eef5ff;
            border-left:4px solid #0d6efd;
            padding:15px;
            border-radius:5px;
        }

        footer{
            font-size:14px;
            color:#666;
        }
    </style>
</head>

<body>

@include('public-form.partials._header')

<div class="container form-container">

    <div class="card">

        <div class="card-header text-center">
            <h2 class="mb-1">Feedback, Compliments & Complaints</h2>
            <p class="mb-0">
                Infinite Ability is committed to providing high quality services and values your feedback.
            </p>
        </div>

        <div class="card-body">

            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Please fix the following:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('feedback.store') }}">
                @csrf
                <input type="hidden" name="city_name" value="General">

                <!-- Privacy -->
                <div class="info-box mb-4">
                    <h5>Your Privacy & Confidentiality</h5>

                    <p class="mb-0">
                        The information you provide is strictly confidential and will only
                        be viewed by authorised staff to respond to your feedback or complaint.
                    </p>
                </div>

                <!-- Contact Details -->

                <h5 class="section-title">Your Contact Details</h5>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2"></textarea>
                    </div>

                </div>

                <hr class="my-4">

                <!-- Interpreter -->

                <h5 class="section-title">Interpreter Required?</h5>

                <div class="row">

                    <div class="col-md-6">

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="wants_interpreter" value="1" id="interpreter">
                            <label class="form-check-label" for="interpreter">
                                Yes, I would like a FREE Interpreter
                            </label>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label" for="interpreter_language">Language</label>

                        <input type="text" name="interpreter_language" class="form-control" id="interpreter_language">

                    </div>

                </div>

                <hr class="my-4">

                <!-- Response -->

                <h5 class="section-title">Would you like a response?</h5>

                <div class="row">

                    <div class="col-md-6">

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="wants_response" value="1" id="response_yes">
                            <label class="form-check-label" for="response_yes">Yes</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="wants_response" value="0" id="response_no">
                            <label class="form-check-label" for="response_no">No</label>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label" for="preferred_contact_method">Preferred Contact Method</label>

                        <select class="form-select" name="preferred_contact_method" id="preferred_contact_method">
                            <option value="email">Email</option>
                            <option value="phone">Phone</option>
                            <option value="post">Mail</option>
                        </select>

                    </div>

                </div>

                <hr class="my-4">

                <!-- Feedback Type -->

                <h5 class="section-title">This is a</h5>

                <div class="row">

                    <div class="col-md-4">

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="feedback_type" value="compliment" id="type_compliment">
                            <label class="form-check-label" for="type_compliment">
                                Compliment
                            </label>
                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="feedback_type" value="complaint" id="type_complaint">
                            <label class="form-check-label" for="type_complaint">
                                Complaint
                            </label>
                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="feedback_type" value="comment" id="type_comment">
                            <label class="form-check-label" for="type_comment">
                                Comment
                            </label>
                        </div>

                    </div>

                </div>
                @error('feedback_type')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror

                <hr class="my-4">

                <!-- I Am -->

                <h5 class="section-title">I am a</h5>

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="respondent_type" value="participant" id="role_participant">
                            <label class="form-check-label" for="role_participant">Participant</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="respondent_type" value="family_member" id="role_family">
                            <label class="form-check-label" for="role_family">Family Member</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="respondent_type" value="participants_representative" id="role_representative">
                            <label class="form-check-label" for="role_representative">Participant's Representative</label>
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="respondent_type" value="staff_member" id="role_staff">
                            <label class="form-check-label" for="role_staff">Staff Member</label>
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="respondent_type" value="staff_on_behalf_of_participant" id="role_staff_on_behalf">
                            <label class="form-check-label" for="role_staff_on_behalf">
                                Staff on behalf of Participant
                            </label>
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="respondent_type" value="other" id="role_other">
                            <label class="form-check-label" for="role_other">Other</label>
                        </div>
                        <input type="text" name="respondent_type_other" class="form-control mt-1" placeholder="Please specify">
                    </div>

                </div>
                @error('respondent_type')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror

                <hr class="my-4">

                <!-- Experience -->

                <h5 class="section-title">
                    Please tell us about your experience
                </h5>

                <textarea name="experience" class="form-control mb-4" rows="6"></textarea>

                <h5 class="section-title">
                    Suggestions / Ideas
                </h5>

                <textarea name="suggestions" class="form-control" rows="6"></textarea>

                <hr class="my-4">

                <!-- Submit -->

                <div class="text-center">

                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        Submit Feedback
                    </button>

                    <button type="reset" class="btn btn-outline-secondary btn-lg px-5 ms-2">
                        Reset
                    </button>

                </div>

            </form>

        </div>

    </div>

    <!-- Footer -->

    <div class="card mt-4">

        <div class="card-body">

            <h5 class="text-primary">How to Lodge Feedback</h5>

            <ul>
                <li>Directly with a staff member.</li>
                <li>Email: <strong>info@infiniteability.com.au</strong></li>
                <li>Phone: <strong>1300 044 422</strong></li>
                <li>Mail: Infinite Ability, 268 Settlement Rd, Thomastown, VIC 3074</li>
                <li>Anonymous Suggestion Box.</li>
            </ul>

            <hr>

            <footer>
                <strong>Response Time:</strong> Complaints will be acknowledged
                within <strong>2 working days</strong> and responded to within
                <strong>28 days</strong> wherever possible.
            </footer>

        </div>

    </div>

</div>

@include('public-form.partials._footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>lucide.createIcons();</script>

</body>
</html>
