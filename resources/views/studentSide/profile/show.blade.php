<x-studentapp-layout>

    <x-slot name="title">
        My Profile
    </x-slot>

    <div class="dashboard">
        <div class="dashboard-header">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="dashboard-title">My Profile</h1>
                    <p class="dashboard-subtitle">View your personal information and account details</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('studentSide.profile.edit') }}" class="btn-primary">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Profile
                    </a>
                    <a href="{{ route('studentSide.dashboard') }}" class="btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="enrollment-alert success">
            <i class="fas fa-check-circle alert-icon"></i>
            <div class="alert-content">
                <div class="alert-title">Success!</div>
                <div class="alert-message">{{ session('success') }}</div>
            </div>
        </div>
        @endif

        <div class="cards-grid">
            <!-- Personal Information Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user mr-2"></i>
                        Personal Information
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Profile Picture Section -->
                    <div class="profile-picture-section mb-6">
                        <div class="flex items-center space-x-6">
                            @if(auth()->user()->avatar)
                            <img src="{{ Storage::url(auth()->user()->avatar) }}"
                                alt="Profile Picture"
                                class="profile-avatar">
                            @else
                            <div class="profile-avatar-placeholder">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            @endif
                            <div>
                                <h2 class="profile-name">{{ $student->first_name }} {{ $student->last_name }}</h2>
                                <p class="profile-email">{{ $student->email }}</p>
                                <p class="profile-id">Student ID: {{ $student->student_id ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="profile-info-grid">
                        <div class="info-item">
                            <label class="info-label">First Name</label>
                            <div class="info-value">{{ $student->first_name }}</div>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Last Name</label>
                            <div class="info-value">{{ $student->last_name }}</div>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Email Address</label>
                            <div class="info-value">{{ $student->email }}</div>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Contact Number</label>
                            <div class="info-value">{{ $student->contact_number }}</div>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Date of Birth</label>
                            <div class="info-value">
                                {{ $student->date_of_birth ? $student->date_of_birth->format('F j, Y') : 'Not specified' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Gender</label>
                            <div class="info-value">{{ $student->gender ?? 'Not specified' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Information Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        Address Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="profile-info-grid">
                        <div class="info-item">
                            <label class="info-label">Country</label>
                            <div class="info-value">{{ $student->country ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Province/State</label>
                            <div class="info-value">{{ $student->province ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-item">
                            <label class="info-label">City</label>
                            <div class="info-value">{{ $student->city ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Zip Code</label>
                            <div class="info-value">{{ $student->zipcode ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-item full-width">
                            <label class="info-label">Street Address</label>
                            <div class="info-value">{{ $student->street ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-item full-width">
                            <label class="info-label">Complete Address</label>
                            <div class="info-value address-complete">
                                {{ $student->street ?? '' }}
                                @if($student->street && ($student->city || $student->province || $student->zipcode)), @endif
                                {{ $student->city ?? '' }}
                                @if($student->city && ($student->province || $student->zipcode)), @endif
                                {{ $student->province ?? '' }}
                                @if($student->province && $student->zipcode) @endif
                                {{ $student->zipcode ?? '' }}
                                @if(($student->city || $student->province || $student->zipcode) && $student->country), @endif
                                {{ $student->country ?? '' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Information Card -->
        <div class="card mt-6">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-cog mr-2"></i>
                    Account Information
                </h3>
            </div>
            <div class="card-body">
                <div class="profile-info-grid">
                    <div class="info-item">
                        <label class="info-label">Account Created</label>
                        <div class="info-value">
                            {{ auth()->user()->created_at ? auth()->user()->created_at->format('F j, Y \a\t g:i A') : 'Not available' }}
                        </div>
                    </div>
                    <div class="info-item">
                        <label class="info-label">Last Updated</label>
                        <div class="info-value">
                            {{ $student->updated_at ? $student->updated_at->format('F j, Y \a\t g:i A') : 'Not available' }}
                        </div>
                    </div>
                    <div class="info-item">
                        <label class="info-label">Account Status</label>
                        <div class="info-value">
                            <span class="status-badge active">
                                <i class="fas fa-check-circle mr-1"></i>
                                Active
                            </span>
                        </div>
                    </div>
                    <div class="info-item">
                        <label class="info-label">Email Verified</label>
                        <div class="info-value">
                            @if(auth()->user()->email_verified_at)
                            <span class="status-badge verified">
                                <i class="fas fa-shield-check mr-1"></i>
                                Verified
                            </span>
                            @else
                            <span class="status-badge unverified">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Not Verified
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <style>
        /* Profile-specific styles */
        .profile-picture-section {
            border-bottom: 1px solid var(--border-light);
            padding-bottom: 1.5rem;
        }

        .dark .profile-picture-section {
            border-color: rgba(255, 255, 255, 0.1);
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary);
        }

        .profile-avatar-placeholder {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
            font-weight: 600;
            border: 3px solid var(--primary);
        }

        .profile-name {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 4px;
            color: var(--text-light);
        }

        .dark .profile-name {
            color: var(--text-dark);
        }

        .profile-email {
            font-size: 16px;
            color: var(--primary);
            margin-bottom: 2px;
        }

        .profile-id {
            font-size: 14px;
            color: var(--text-muted-light);
        }

        .dark .profile-id {
            color: var(--text-muted-dark);
        }

        .profile-info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-item.full-width {
            grid-column: 1 / -1;
        }

        .info-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-muted-light);
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .dark .info-label {
            color: var(--text-muted-dark);
        }

        .info-value {
            font-size: 16px;
            font-weight: 500;
            color: var(--text-light);
            padding: 8px 0;
        }

        .dark .info-value {
            color: var(--text-dark);
        }

        .address-complete {
            font-style: italic;
            background-color: var(--light-bg);
            padding: 12px;
            border-radius: 6px;
            border-left: 3px solid var(--primary);
        }

        .dark .address-complete {
            background-color: var(--dark-bg);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .status-badge.active {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .status-badge.verified {
            background-color: rgba(59, 130, 246, 0.1);
            color: var(--info);
        }

        .status-badge.unverified {
            background-color: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .action-description {
            font-size: 12px;
            color: var(--text-muted-light);
            margin-top: 4px;
        }

        .dark .action-description {
            color: var(--text-muted-dark);
        }

        /* Utility classes */
        .flex {
            display: flex;
        }

        .items-center {
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .space-x-4>*+* {
            margin-left: 1rem;
        }

        .space-x-6>*+* {
            margin-left: 1.5rem;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .mt-6 {
            margin-top: 1.5rem;
        }

        .mr-1 {
            margin-right: 0.25rem;
        }

        .mr-2 {
            margin-right: 0.5rem;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .profile-info-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .profile-picture-section .flex {
                flex-direction: column;
                text-align: center;
            }

            .profile-picture-section .space-x-6>*+* {
                margin-left: 0;
                margin-top: 1rem;
            }

            .dashboard-header .flex {
                flex-direction: column;
                align-items: flex-start;
            }

            .dashboard-header .space-x-4 {
                margin-top: 1rem;
            }

            .dashboard-header .space-x-4>*+* {
                margin-left: 0;
                margin-top: 0.5rem;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</x-studentapp-layout>