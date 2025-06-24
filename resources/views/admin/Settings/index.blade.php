@extends('admin.layouts.app')

@section('title', 'Settings')

@section('styles')
<style>
    .nav-pills .nav-link {
        color: #6c757d;
        background-color: transparent;
        border: 1px solid #dee2e6;
        margin-bottom: 5px;
    }
    
    .nav-pills .nav-link.active {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .nav-pills .nav-link:hover {
        color: #007bff;
        background-color: #f8f9fa;
    }
    
    .settings-card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .form-group label {
        font-weight: 600;
        color: #495057;
    }
    
    .current-logo, .current-favicon {
        max-width: 100px;
        max-height: 100px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 5px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Settings</h1>
        <a href="{{ route('admin.settings.clear-cache') }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"
           onclick="return confirm('Are you sure you want to clear all cache?')">
            <i class="fas fa-broom fa-sm text-white-50"></i> Clear Cache
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-3">
            <div class="card settings-card">
                <div class="card-body">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-general-tab" data-toggle="pill" href="#v-pills-general" 
                           role="tab" aria-controls="v-pills-general" aria-selected="true">
                            <i class="fas fa-cog mr-2"></i>General Settings
                        </a>
                        <a class="nav-link" id="v-pills-branding-tab" data-toggle="pill" href="#v-pills-branding" 
                           role="tab" aria-controls="v-pills-branding" aria-selected="false">
                            <i class="fas fa-palette mr-2"></i>Branding
                        </a>
                        <a class="nav-link" id="v-pills-seo-tab" data-toggle="pill" href="#v-pills-seo" 
                           role="tab" aria-controls="v-pills-seo" aria-selected="false">
                            <i class="fas fa-search mr-2"></i>SEO Settings
                        </a>
                        <a class="nav-link" id="v-pills-email-tab" data-toggle="pill" href="#v-pills-email" 
                           role="tab" aria-controls="v-pills-email" aria-selected="false">
                            <i class="fas fa-envelope mr-2"></i>Email Settings
                        </a>
                        <a class="nav-link" id="v-pills-payment-tab" data-toggle="pill" href="#v-pills-payment" 
                           role="tab" aria-controls="v-pills-payment" aria-selected="false">
                            <i class="fas fa-credit-card mr-2"></i>Payment Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="tab-content" id="v-pills-tabContent">
                
                <!-- General Settings Tab -->
                <div class="tab-pane fade show active" id="v-pills-general" role="tabpanel" aria-labelledby="v-pills-general-tab">
                    <div class="card settings-card">
                        <div class="card-header">
                            <h5 class="mb-0">General Settings</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.update-general') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="site_name">Site Name *</label>
                                            <input type="text" class="form-control @error('site_name') is-invalid @enderror" 
                                                   id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" required>
                                            @error('site_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_email">Contact Email *</label>
                                            <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                                                   id="contact_email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}" required>
                                            @error('contact_email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="site_description">Site Description</label>
                                    <textarea class="form-control @error('site_description') is-invalid @enderror" 
                                              id="site_description" name="site_description" rows="3">{{ old('site_description', $settings['site_description']) }}</textarea>
                                    @error('site_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_phone">Contact Phone</label>
                                            <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" 
                                                   id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}">
                                            @error('contact_phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                                   id="address" name="address" value="{{ old('address', $settings['address']) }}">
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <h6 class="mt-4 mb-3 text-primary">Social Media Links</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="facebook_url">Facebook URL</label>
                                            <input type="url" class="form-control @error('facebook_url') is-invalid @enderror" 
                                                   id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url']) }}">
                                            @error('facebook_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="instagram_url">Instagram URL</label>
                                            <input type="url" class="form-control @error('instagram_url') is-invalid @enderror" 
                                                   id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url']) }}">
                                            @error('instagram_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="twitter_url">Twitter URL</label>
                                            <input type="url" class="form-control @error('twitter_url') is-invalid @enderror" 
                                                   id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $settings['twitter_url']) }}">
                                            @error('twitter_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="youtube_url">YouTube URL</label>
                                            <input type="url" class="form-control @error('youtube_url') is-invalid @enderror" 
                                                   id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $settings['youtube_url']) }}">
                                            @error('youtube_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-2"></i>Save General Settings
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Branding Tab -->
                <div class="tab-pane fade" id="v-pills-branding" role="tabpanel" aria-labelledby="v-pills-branding-tab">
                    <div class="card settings-card">
                        <div class="card-header">
                            <h5 class="mb-0">Branding Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-primary">Site Logo</h6>
                                    @if($settings['site_logo'])
                                        <div class="mb-3">
                                            <img src="{{ Storage::url($settings['site_logo']) }}" alt="Current Logo" class="current-logo">
                                        </div>
                                    @endif
                                    <form action="{{ route('admin.settings.upload-logo') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="logo">Upload New Logo</label>
                                            <input type="file" class="form-control-file @error('logo') is-invalid @enderror" 
                                                   id="logo" name="logo" accept="image/*">
                                            <small class="form-text text-muted">Recommended size: 200x60px, Max: 2MB</small>
                                            @error('logo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-upload mr-2"></i>Upload Logo
                                        </button>
                                    </form>
                                </div>

                                <div class="col-md-6">
                                    <h6 class="text-primary">Favicon</h6>
                                    @if($settings['site_favicon'])
                                        <div class="mb-3">
                                            <img src="{{ Storage::url($settings['site_favicon']) }}" alt="Current Favicon" class="current-favicon">
                                        </div>
                                    @endif
                                    <form action="{{ route('admin.settings.upload-favicon') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="favicon">Upload New Favicon</label>
                                            <input type="file" class="form-control-file @error('favicon') is-invalid @enderror" 
                                                   id="favicon" name="favicon" accept=".ico,.png">
                                            <small class="form-text text-muted">Recommended: ICO format, 32x32px, Max: 512KB</small>
                                            @error('favicon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-upload mr-2"></i>Upload Favicon
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO Settings Tab -->
                <div class="tab-pane fade" id="v-pills-seo" role="tabpanel" aria-labelledby="v-pills-seo-tab">
                    <div class="card settings-card">
                        <div class="card-header">
                            <h5 class="mb-0">SEO Settings</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.update-seo') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="meta_title">Meta Title</label>
                                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                           id="meta_title" name="meta_title" value="{{ old('meta_title', $settings['meta_title']) }}">
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                              id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $settings['meta_description']) }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="meta_keywords">Meta Keywords</label>
                                    <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" 
                                           id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $settings['meta_keywords']) }}">
                                    <small class="form-text text-muted">Separate keywords with commas</small>
                                    @error('meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="google_analytics_id">Google Analytics ID</label>
                                            <input type="text" class="form-control @error('google_analytics_id') is-invalid @enderror" 
                                                   id="google_analytics_id" name="google_analytics_id" 
                                                   value="{{ old('google_analytics_id', $settings['google_analytics_id']) }}"
                                                   placeholder="GA-XXXXXXXXX-X">
                                            @error('google_analytics_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="google_search_console">Google Search Console</label>
                                            <input type="text" class="form-control @error('google_search_console') is-invalid @enderror" 
                                                   id="google_search_console" name="google_search_console" 
                                                   value="{{ old('google_search_console', $settings['google_search_console']) }}"
                                                   placeholder="google-site-verification=...">
                                            @error('google_search_console')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="facebook_pixel_id">Facebook Pixel ID</label>
                                    <input type="text" class="form-control @error('facebook_pixel_id') is-invalid @enderror" 
                                           id="facebook_pixel_id" name="facebook_pixel_id" 
                                           value="{{ old('facebook_pixel_id', $settings['facebook_pixel_id']) }}"
                                           placeholder="123456789012345">
                                    @error('facebook_pixel_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-2"></i>Save SEO Settings
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Email Settings Tab -->
                <div class="tab-pane fade" id="v-pills-email" role="tabpanel" aria-labelledby="v-pills-email-tab">
                    <div class="card settings-card">
                        <div class="card-header">
                            <h5 class="mb-0">Email Settings</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.update-email') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mail_driver">Mail Driver *</label>
                                            <select class="form-control @error('mail_driver') is-invalid @enderror" 
                                                    id="mail_driver" name="mail_driver" required>
                                                <option value="smtp" {{ old('mail_driver', $settings['mail_driver']) == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                                <option value="sendmail" {{ old('mail_driver', $settings['mail_driver']) == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                                <option value="mailgun" {{ old('mail_driver', $settings['mail_driver']) == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                                                <option value="postmark" {{ old('mail_driver', $settings['mail_driver']) == 'postmark' ? 'selected' : '' }}>Postmark</option>
                                            </select>
                                            @error('mail_driver')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mail_host">Mail Host</label>
                                            <input type="text" class="form-control @error('mail_host') is-invalid @enderror" 
                                                   id="mail_host" name="mail_host" 
                                                   value="{{ old('mail_host', $settings['mail_host']) }}"
                                                   placeholder="smtp.gmail.com">
                                            @error('mail_host')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mail_port">Mail Port</label>
                                            <input type="number" class="form-control @error('mail_port') is-invalid @enderror" 
                                                   id="mail_port" name="mail_port" 
                                                   value="{{ old('mail_port', $settings['mail_port']) }}"
                                                   placeholder="587">
                                            @error('mail_port')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mail_encryption">Mail Encryption</label>
                                            <select class="form-control @error('mail_encryption') is-invalid @enderror" 
                                                    id="mail_encryption" name="mail_encryption">
                                                <option value="">None</option>
                                                <option value="tls" {{ old('mail_encryption', $settings['mail_encryption']) == 'tls' ? 'selected' : '' }}>TLS</option>
                                                <option value="ssl" {{ old('mail_encryption', $settings['mail_encryption']) == 'ssl' ? 'selected' : '' }}>SSL</option>
                                            </select>
                                            @error('mail_encryption')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mail_username">Mail Username</label>
                                            <input type="text" class="form-control @error('mail_username') is-invalid @enderror" 
                                                   id="mail_username" name="mail_username" 
                                                   value="{{ old('mail_username', $settings['mail_username']) }}">
                                            @error('mail_username')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mail_password">Mail Password</label>
                                            <input type="password" class="form-control @error('mail_password') is-invalid @enderror" 
                                                   id="mail_password" name="mail_password" 
                                                   placeholder="Leave empty to keep current password">
                                            <small class="form-text text-muted">Leave empty to keep the current password</small>
                                            @error('mail_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mail_from_address">From Email Address *</label>
                                            <input type="email" class="form-control @error('mail_from_address') is-invalid @enderror" 
                                                   id="mail_from_address" name="mail_from_address" 
                                                   value="{{ old('mail_from_address', $settings['mail_from_address']) }}" required>
                                            @error('mail_from_address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mail_from_name">From Name *</label>
                                            <input type="text" class="form-control @error('mail_from_name') is-invalid @enderror" 
                                                   id="mail_from_name" name="mail_from_name" 
                                                   value="{{ old('mail_from_name', $settings['mail_from_name']) }}" required>
                                            @error('mail_from_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-2"></i>Save Email Settings
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Payment Settings Tab -->
                <div class="tab-pane fade" id="v-pills-payment" role="tabpanel" aria-labelledby="v-pills-payment-tab">
                    <div class="card settings-card">
                        <div class="card-header">
                            <h5 class="mb-0">Payment Settings</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.update-payment') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="currency">Currency *</label>
                                            <select class="form-control @error('currency') is-invalid @enderror" 
                                                    id="currency" name="currency" required>
                                                <option value="USD" {{ old('currency', $settings['currency']) == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                                <option value="EUR" {{ old('currency', $settings['currency']) == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                                <option value="GBP" {{ old('currency', $settings['currency']) == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                                <option value="JOD" {{ old('currency', $settings['currency']) == 'JOD' ? 'selected' : '' }}>JOD - Jordanian Dinar</option>
                                                <option value="SAR" {{ old('currency', $settings['currency']) == 'SAR' ? 'selected' : '' }}>SAR - Saudi Riyal</option>
                                                <option value="AED" {{ old('currency', $settings['currency']) == 'AED' ? 'selected' : '' }}>AED - UAE Dirham</option>
                                            </select>
                                            @error('currency')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="currency_symbol">Currency Symbol *</label>
                                            <input type="text" class="form-control @error('currency_symbol') is-invalid @enderror" 
                                                   id="currency_symbol" name="currency_symbol" 
                                                   value="{{ old('currency_symbol', $settings['currency_symbol']) }}" 
                                                   placeholder="$" required>
                                            @error('currency_symbol')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Payment Methods *</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               id="payment_credit_card" name="payment_methods[]" value="credit_card"
                                               {{ in_array('credit_card', json_decode($settings['payment_methods'], true)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="payment_credit_card">
                                            Credit Card
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               id="payment_paypal" name="payment_methods[]" value="paypal"
                                               {{ in_array('paypal', json_decode($settings['payment_methods'], true)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="payment_paypal">
                                            PayPal
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               id="payment_bank_transfer" name="payment_methods[]" value="bank_transfer"
                                               {{ in_array('bank_transfer', json_decode($settings['payment_methods'], true)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="payment_bank_transfer">
                                            Bank Transfer
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               id="payment_cash_on_delivery" name="payment_methods[]" value="cash_on_delivery"
                                               {{ in_array('cash_on_delivery', json_decode($settings['payment_methods'], true)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="payment_cash_on_delivery">
                                            Cash on Delivery
                                        </label>
                                    </div>
                                    @error('payment_methods')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <h6 class="mt-4 mb-3 text-primary">Stripe Settings</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="stripe_publishable_key">Stripe Publishable Key</label>
                                            <input type="text" class="form-control @error('stripe_publishable_key') is-invalid @enderror" 
                                                   id="stripe_publishable_key" name="stripe_publishable_key" 
                                                   value="{{ old('stripe_publishable_key', $settings['stripe_publishable_key']) }}"
                                                   placeholder="pk_test_...">
                                            @error('stripe_publishable_key')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="stripe_secret_key">Stripe Secret Key</label>
                                            <input type="password" class="form-control @error('stripe_secret_key') is-invalid @enderror" 
                                                   id="stripe_secret_key" name="stripe_secret_key" 
                                                   placeholder="sk_test_... (leave empty to keep current)">
                                            @error('stripe_secret_key')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <h6 class="mt-4 mb-3 text-primary">PayPal Settings</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="paypal_mode">PayPal Mode *</label>
                                            <select class="form-control @error('paypal_mode') is-invalid @enderror" 
                                                    id="paypal_mode" name="paypal_mode" required>
                                                <option value="sandbox" {{ old('paypal_mode', $settings['paypal_mode']) == 'sandbox' ? 'selected' : '' }}>Sandbox (Test)</option>
                                                <option value="live" {{ old('paypal_mode', $settings['paypal_mode']) == 'live' ? 'selected' : '' }}>Live (Production)</option>
                                            </select>
                                            @error('paypal_mode')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="paypal_client_id">PayPal Client ID</label>
                                            <input type="text" class="form-control @error('paypal_client_id') is-invalid @enderror" 
                                                   id="paypal_client_id" name="paypal_client_id" 
                                                   value="{{ old('paypal_client_id', $settings['paypal_client_id']) }}">
                                            @error('paypal_client_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="paypal_client_secret">PayPal Client Secret</label>
                                            <input type="password" class="form-control @error('paypal_client_secret') is-invalid @enderror" 
                                                   id="paypal_client_secret" name="paypal_client_secret" 
                                                   placeholder="Leave empty to keep current">
                                            @error('paypal_client_secret')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-2"></i>Save Payment Settings
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Show/hide SMTP fields based on mail driver selection
    $('#mail_driver').change(function() {
        var driver = $(this).val();
        if (driver === 'smtp') {
            $('#mail_host, #mail_port, #mail_username, #mail_password, #mail_encryption').closest('.form-group').show();
        } else {
            $('#mail_host, #mail_port, #mail_username, #mail_password, #mail_encryption').closest('.form-group').hide();
        }
    });

    // Trigger change event on page load
    $('#mail_driver').trigger('change');

    // Auto-update currency symbol based on currency selection
    $('#currency').change(function() {
        var currency = $(this).val();
        var symbols = {
            'USD': '$',
            'EUR': '€',
            'GBP': '£',
            'JOD': 'JD',
            'SAR': 'SR',
            'AED': 'AED'
        };
        $('#currency_symbol').val(symbols[currency] || '$');
    });

    // Form validation
    $('form').submit(function(e) {
        var form = $(this);
        var isValid = true;

        // Validate required fields
        form.find('input[required], select[required], textarea[required]').each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Validate payment methods
        if (form.find('input[name="payment_methods[]"]').length > 0) {
            if (!form.find('input[name="payment_methods[]"]:checked').length) {
                alert('Please select at least one payment method.');
                isValid = false;
            }
        }

        if (!isValid) {
            e.preventDefault();
        }
    });

    // Show success message and auto-hide after 5 seconds
    $('.alert-success').delay(5000).fadeOut('slow');
});
</script>
@endsection