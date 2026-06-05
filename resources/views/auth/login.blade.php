<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .login-container { max-width: 400px; margin-top: 100px; }
        /* Tùy chỉnh con trỏ chuột cho nút mắt */
        #togglePassword { cursor: pointer; }
    </style>
</head>
<body>

<div class="container login-container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">ĐĂNG NHẬP</h4>
        </div>
        <div class="card-body p-4">
            
            @if($errors->any())
                <div class="alert alert-danger py-2">
                    <ul class="mb-0" style="padding-left: 15px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required placeholder="nhập email của bạn...">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" required placeholder="••••••••">
                        <span class="input-group-text bg-white" id="togglePassword">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                    <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                </div>

                <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
            </form>

        </div>
    </div>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function () {
        // Kiểm tra xem input đang là password hay text
        const isPassword = passwordInput.getAttribute('type') === 'password';
        
        // Đổi type
        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
        
        // Đổi icon mắt (từ bi-eye sang bi-eye-slash và ngược lại)
        if (isPassword) {
            eyeIcon.classList.remove('bi-eye');
            eyeIcon.classList.add('bi-eye-slash'); // Icon nhắm mắt
        } else {
            eyeIcon.classList.remove('bi-eye-slash');
            eyeIcon.classList.add('bi-eye'); // Icon mở mắt
        }
    });
</script>

</body>
</html>