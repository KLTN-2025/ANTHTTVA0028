import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';
import api from '../../services/api';
import { Button } from '../../components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '../../components/ui/card';
import { GraduationCap, Loader2 } from 'lucide-react';
import Swal from 'sweetalert2';

export default function LoginPage() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [role, setRole] = useState<'student' | 'instructor'>('student');
    const [isLoading, setIsLoading] = useState(false);
    const { login } = useAuth();
    const navigate = useNavigate();

    const handleLogin = async (e: React.FormEvent) => {
        e.preventDefault();
        setIsLoading(true);

        try {
            const response = await api.post('/login', {
                email,
                password,
                role
            });

            const { access_token, user } = response.data;

            // Add role to user object for context
            const userWithRole = { ...user, role };

            login(access_token, userWithRole);

            Swal.fire({
                icon: 'success',
                title: 'Đăng nhập thành công!',
                showConfirmButton: false,
                timer: 1500
            });

            if (role === 'student') {
                navigate('/student/dashboard');
            } else {
                navigate('/instructor/dashboard');
            }
        } catch (error: any) {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Đăng nhập thất bại',
                text: error.response?.data?.message || 'Email hoặc mật khẩu không đúng.',
            });
        } finally {
            setIsLoading(false);
        }
    };

    return (
        <div className="min-h-screen bg-gradient-to-br from-primary-50 to-white flex items-center justify-center p-4">
            <Card className="w-full max-w-md shadow-xl border-primary-100">
                <CardHeader className="text-center space-y-2 pb-6">
                    <div className="flex justify-center mb-2">
                        <div className="h-16 w-16 bg-primary-100 rounded-full flex items-center justify-center text-primary-600">
                            <GraduationCap className="h-10 w-10" />
                        </div>
                    </div>
                    <CardTitle className="text-2xl font-bold text-gray-900">Đăng nhập AgoraLearn</CardTitle>
                    <p className="text-sm text-gray-500">Hệ thống quản lý học tập thông minh</p>
                </CardHeader>
                <CardContent>
                    <form onSubmit={handleLogin} className="space-y-4">
                        <div className="flex p-1 bg-gray-100 rounded-lg">
                            <button
                                type="button"
                                className={`flex-1 py-2 text-sm font-medium rounded-md transition-all ${role === 'student' ? 'bg-white text-primary-600 shadow-sm' : 'text-gray-500 hover:text-gray-900'
                                    }`}
                                onClick={() => setRole('student')}
                            >
                                Sinh viên
                            </button>
                            <button
                                type="button"
                                className={`flex-1 py-2 text-sm font-medium rounded-md transition-all ${role === 'instructor' ? 'bg-white text-primary-600 shadow-sm' : 'text-gray-500 hover:text-gray-900'
                                    }`}
                                onClick={() => setRole('instructor')}
                            >
                                Giảng viên
                            </button>
                        </div>

                        <div className="space-y-2">
                            <label className="text-sm font-medium text-gray-700">Email</label>
                            <input
                                type="email"
                                required
                                className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder={role === 'student' ? 'hocvien@agoralearn.com' : 'giangvien@agoralearn.com'}
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                            />
                        </div>

                        <div className="space-y-2">
                            <label className="text-sm font-medium text-gray-700">Mật khẩu</label>
                            <input
                                type="password"
                                required
                                className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="••••••••"
                                value={password}
                                onChange={(e) => setPassword(e.target.value)}
                            />
                        </div>

                        <Button type="submit" className="w-full" disabled={isLoading}>
                            {isLoading ? (
                                <>
                                    <Loader2 className="mr-2 h-4 w-4 animate-spin" />
                                    Đang xử lý...
                                </>
                            ) : (
                                'Đăng nhập'
                            )}
                        </Button>
                    </form>

                    <div className="mt-6 text-center text-sm text-gray-500">
                        <p>Tài khoản demo:</p>
                        <p>SV: hocvien@agoralearn.com / password</p>
                        <p>GV: giangvien@agoralearn.com / password</p>
                    </div>
                </CardContent>
            </Card>
        </div>
    );
}
