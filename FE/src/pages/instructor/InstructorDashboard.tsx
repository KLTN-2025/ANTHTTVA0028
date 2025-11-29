
import { DashboardLayout } from '../../components/layout/DashboardLayout';
import { Card, CardContent, CardHeader, CardTitle } from '../../components/ui/card';
import { Button } from '../../components/ui/button';
import { Users, BookOpen, Calendar, TrendingUp } from 'lucide-react';

export default function InstructorDashboard() {
    return (
        <DashboardLayout role="instructor">
            <div className="space-y-6">
                <div>
                    <h1 className="text-2xl font-bold text-gray-900">Xin chào, Giảng viên Trần Văn B! 👋</h1>
                    <p className="text-gray-500">Đây là tổng quan công tác giảng dạy của thầy hôm nay.</p>
                </div>

                {/* Stats Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <Card>
                        <CardContent className="p-6 flex items-center gap-4">
                            <div className="p-3 bg-blue-100 text-blue-600 rounded-full">
                                <Users className="h-6 w-6" />
                            </div>
                            <div>
                                <p className="text-sm font-medium text-gray-500">Tổng sinh viên</p>
                                <h3 className="text-2xl font-bold text-gray-900">156</h3>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardContent className="p-6 flex items-center gap-4">
                            <div className="p-3 bg-purple-100 text-purple-600 rounded-full">
                                <BookOpen className="h-6 w-6" />
                            </div>
                            <div>
                                <p className="text-sm font-medium text-gray-500">Lớp đang dạy</p>
                                <h3 className="text-2xl font-bold text-gray-900">5</h3>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardContent className="p-6 flex items-center gap-4">
                            <div className="p-3 bg-green-100 text-green-600 rounded-full">
                                <Calendar className="h-6 w-6" />
                            </div>
                            <div>
                                <p className="text-sm font-medium text-gray-500">Giờ dạy tuần này</p>
                                <h3 className="text-2xl font-bold text-gray-900">18h</h3>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardContent className="p-6 flex items-center gap-4">
                            <div className="p-3 bg-orange-100 text-orange-600 rounded-full">
                                <TrendingUp className="h-6 w-6" />
                            </div>
                            <div>
                                <p className="text-sm font-medium text-gray-500">Tỷ lệ chuyên cần</p>
                                <h3 className="text-2xl font-bold text-gray-900">92%</h3>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <Card>
                        <CardHeader>
                            <CardTitle>Lịch dạy hôm nay</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {[1, 2].map((i) => (
                                    <div key={i} className="flex items-center justify-between p-4 rounded-lg border border-gray-100 hover:bg-gray-50">
                                        <div className="flex items-center gap-4">
                                            <div className="text-center w-16">
                                                <span className="block text-lg font-bold text-primary-600">09:00</span>
                                            </div>
                                            <div>
                                                <h4 className="font-semibold text-gray-900">Lập trình Web nâng cao</h4>
                                                <p className="text-sm text-gray-500">Lớp: CNTT-K15 • Phòng: A204</p>
                                            </div>
                                        </div>
                                        <Button variant="outline" size="sm">Điểm danh</Button>
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>Cần chấm điểm</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {[1, 2, 3].map((i) => (
                                    <div key={i} className="flex items-center justify-between p-4 rounded-lg bg-gray-50">
                                        <div>
                                            <h4 className="font-medium text-gray-900">Bài tập lớn: Xây dựng Website</h4>
                                            <p className="text-sm text-gray-500">Lớp CNTT-K15 • 45 bài chưa chấm</p>
                                        </div>
                                        <Button size="sm">Chấm ngay</Button>
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </DashboardLayout>
    );
}
