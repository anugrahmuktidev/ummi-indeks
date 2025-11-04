<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <button type="button"
                    class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger material-shadow-none"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

            </div>

            <div class="d-flex align-items-center">

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                        class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle"
                        data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                        class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <i class="ri-account-circle-line" style="font-size: 35px;"></i>
                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name }}</span>
                                <span
                                    class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">{{ ucfirst(strtolower(Auth::user()->role)) }}</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <x-dropdown-link data-bs-toggle="modal" data-bs-target="#changePasswordModal"
                            style="cursor: pointer;">
                            {{ __('Ganti Password') }}
                        </x-dropdown-link>
                        <div class="mt-3"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">{{ __('Ganti Password') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="password-update-message" class="alert d-none"></div>
                <form id="update-password-form" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="current_password">{{ __('Password saat ini') }}</label>
                        <input type="password" id="current_password" class="form-control" name="current_password"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="password">{{ __('Password Baru') }}</label>
                        <input type="password" id="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">{{ __('Konfirmasi Password Baru') }}</label>
                        <input type="password" id="password_confirmation" class="form-control"
                            name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">{{ __('Update Password') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#changePasswordModal').on('shown.bs.modal', function() {
        $('#update-password-form').submit(function(event) {
            event.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var data = form.serialize();

            $.ajax({
                type: 'POST',
                url: url,
                data: data + '&_method=PUT',
                success: function(data) {
                    $('#password-update-message').removeClass('d-none alert-danger')
                        .addClass('alert-success').text(data.message);
                    setTimeout(function() {
                        window.location.href =
                            "/dashboard"; // Arahkan ke halaman dashboard
                    }, 2000); // Tunggu 2 detik sebelum diarahkan
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseJSON?.error || "An error occurred";
                    $('#password-update-message').removeClass('d-none alert-success')
                        .addClass('alert-danger').text(errorMessage);
                }
            });



        });
    });
</script>
