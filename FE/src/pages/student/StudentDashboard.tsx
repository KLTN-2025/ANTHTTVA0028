import { useEffect, useState } from 'react';
import { Card, CardContent, CardHeader, CardTitle } from '../../components/ui/card';
import { Button } from '../../components/ui/button';
import { BookOpen, Calendar, Clock, Award, PlayCircle, Bell } from 'lucide-react';
import api from '../../services/api';
import { Loader2 } from 'lucide-react';
import { DashboardLayout } from '../../components/layout/DashboardLayout';

export default function StudentDashboard() {
    const [data, setData] = useState<any>(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await api.get('/student/dashboard');
                setData(response.data);
            } catch (error) {
                console.error("Failed to fetch dashboard data", error);
            } finally {
                setLoading(false);
            }
        };
        fetchData();
    }, []);

    if (loading) {
        return (
            <DashboardLayout role="student">
                <div className="flex justify-center items-center h-96">
                    <Loader2 className="h-8 w-8 animate-spin text-primary-600" />
                </div>
            </DashboardLayout>
        );
    }

    const { stats, upcoming_classes, notifications } = data;

    return (
        <DashboardLayout role="student">
            <div className="space-y-6">
                {/* Welcome Section */}
                <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">Xin chào, Học viên!</h1>
                        <p className="text-gray-500">Chào mừng trở lại với không gian học tập của bạn.</p>
                    </div>
                    <Button className="bg-primary-600 hover:bg-primary-700">
                        <PlayCircle className="mr-2 h-4 w-4" />
                        Tiếp tục học
                    </Button>
                </div>

                {/* Stats Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <Card className="border-l-4 border-l-blue-500 shadow-sm hover:shadow-md transition-shadow">
                        <CardContent className="p-6">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm font-medium text-gray-500">Khóa học đang học</p>
                                    <h3 className="text-3xl font-bold text-gray-900 mt-1">{stats.total_courses}</h3>
                                </div>
                                <div className="h-12 w-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-600">
                                    <BookOpen className="h-6 w-6" />
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="border-l-4 border-l-green-500 shadow-sm hover:shadow-md transition-shadow">
                        <CardContent className="p-6">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm font-medium text-gray-500">Bài tập cần nộp</p>
                                    <h3 className="text-3xl font-bold text-gray-900 mt-1">{stats.assignments_pending}</h3>
                                </div>
                                <div className="h-12 w-12 bg-green-50 rounded-full flex items-center justify-center text-green-600">
                                    <Clock className="h-6 w-6" />
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="border-l-4 border-l-purple-500 shadow-sm hover:shadow-md transition-shadow">
                        <CardContent className="p-6">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm font-medium text-gray-500">Lịch học tuần này</p>
                                    <h3 className="text-3xl font-bold text-gray-900 mt-1">{upcoming_classes.length}</h3>
                                </div>
                                <div className="h-12 w-12 bg-purple-50 rounded-full flex items-center justify-center text-purple-600">
                                    <Calendar className="h-6 w-6" />
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="border-l-4 border-l-orange-500 shadow-sm hover:shadow-md transition-shadow">
                        <CardContent className="p-6">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm font-medium text-gray-500">Điểm trung bình</p>
                                    <h3 className="text-3xl font-bold text-gray-900 mt-1">{stats.average_score}</h3>
                                </div>
                                <div className="h-12 w-12 bg-orange-50 rounded-full flex items-center justify-center text-orange-600">
                                    <Award className="h-6 w-6" />
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Upcoming Classes */}
                    <Card className="lg:col-span-2 shadow-sm">
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                <Calendar className="h-5 w-5 text-primary-600" />
                                Lịch học sắp tới
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {upcoming_classes.length > 0 ? (
                                    upcoming_classes.map((cls: any) => (
                                        <div key={cls.id} className="flex items-start gap-4 p-4 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors">
                                            <div className="flex-shrink-0 w-16 text-center bg-primary-50 rounded-lg p-2">
                                                <span className="block text-xs font-semibold text-primary-600 uppercase">
                                                    {cls.thoi_gian.split(' ')[1]}
                                                </span>
                                                <span className="block text-lg font-bold text-primary-700">
                                                    {cls.thoi_gian.split(' ')[0].split('/')[0]}
                                                </span>
                                            </div>
                                            <div className="flex-1">
                                                <h4 className="font-semibold text-gray-900">{cls.ten_khoa_hoc}</h4>
                                                <p className="text-sm text-gray-500">{cls.ten_lop}</p>
                                                <div className="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                                    <span className="flex items-center gap-1">
                                                        <Clock className="h-3 w-3" /> {cls.thoi_gian.split(' ')[0]}
                                                    </span>
                                                    <span className="flex items-center gap-1">
                                                        <span className={`h-2 w-2 rounded-full ${cls.hinh_thuc === 'online' ? 'bg-green-500' : 'bg-blue-500'}`}></span>
                                                        {cls.hinh_thuc === 'online' ? 'Online' : 'Offline'} ({cls.phong})
                                                    </span>
                                                </div>
                                            </div>
                                            <Button variant="outline" size="sm">Chi tiết</Button>
                                        </div>
                                    ))
                                ) : (
                                    <p className="text-center text-gray-500">Không có lịch học sắp tới.</p>
                                )}
                            </div>
                        </CardContent>
                    </Card>

                    {/* Notifications */}
                    <Card className="shadow-sm">
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                <Bell className="h-5 w-5 text-primary-600" />
                                Thông báo mới
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {notifications.length > 0 ? (
                                    notifications.map((notif: any) => (
                                        <div key={notif.id} className="flex gap-3 pb-3 border-b border-gray-100 last:border-0 last:pb-0">
                                            <div className="h-2 w-2 mt-2 rounded-full bg-blue-500 flex-shrink-0"></div>
                                            <div>
                                                <h4 className="text-sm font-medium text-gray-900">{notif.tieu_de}</h4>
                                                <p className="text-xs text-gray-500 mt-1 line-clamp-2">{notif.noi_dung}</p>
                                                <span className="text-[10px] text-gray-400 mt-1 block">
                                                    {new Date(notif.created_at).toLocaleDateString('vi-VN')}
                                                </span>
                                            </div>
                                        </div>
                                    ))
                                ) : (
                                    <p className="text-center text-gray-500">Không có thông báo mới.</p>
                                )}
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </DashboardLayout>
    );
}
