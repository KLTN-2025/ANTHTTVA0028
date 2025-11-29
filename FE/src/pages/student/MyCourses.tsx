import { useEffect, useState } from 'react';
import { Card, CardContent } from '../../components/ui/card';
import { Button } from '../../components/ui/button';
import { BookOpen, User, ArrowRight, Search, Filter } from 'lucide-react';
import { Link } from 'react-router-dom';
import api from '../../services/api';
import { Loader2 } from 'lucide-react';
import { DashboardLayout } from '../../components/layout/DashboardLayout';

export default function MyCourses() {
    const [courses, setCourses] = useState<any[]>([]);
    const [loading, setLoading] = useState(true);
    const [searchTerm, setSearchTerm] = useState('');

    useEffect(() => {
        const fetchCourses = async () => {
            try {
                const response = await api.get('/student/courses');
                setCourses(response.data);
            } catch (error) {
                console.error("Failed to fetch courses", error);
            } finally {
                setLoading(false);
            }
        };
        fetchCourses();
    }, []);

    const filteredCourses = courses.filter(course =>
        course.ten_khoa_hoc.toLowerCase().includes(searchTerm.toLowerCase()) ||
        course.ma_lop.toLowerCase().includes(searchTerm.toLowerCase())
    );

    if (loading) {
        return (
            <DashboardLayout role="student">
                <div className="flex justify-center items-center h-96">
                    <Loader2 className="h-8 w-8 animate-spin text-primary-600" />
                </div>
            </DashboardLayout>
        );
    }

    return (
        <DashboardLayout role="student">
            <div className="space-y-6">
                <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">Khóa học của tôi</h1>
                        <p className="text-gray-500">Quản lý và theo dõi tiến độ các khóa học của bạn.</p>
                    </div>
                    <div className="flex gap-2 w-full md:w-auto">
                        <div className="relative flex-1 md:w-64">
                            <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
                            <input
                                type="text"
                                placeholder="Tìm kiếm khóa học..."
                                className="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                            />
                        </div>
                        <Button variant="outline" size="icon">
                            <Filter className="h-4 w-4" />
                        </Button>
                    </div>
                </div>

                {filteredCourses.length > 0 ? (
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {filteredCourses.map((course) => (
                            <Card key={course.id} className="group hover:shadow-lg transition-all duration-300 border-gray-200">
                                <div className="relative h-48 bg-gray-100 rounded-t-xl overflow-hidden">
                                    {course.anh_bia ? (
                                        <img src={course.anh_bia} alt={course.ten_khoa_hoc} className="w-full h-full object-cover" />
                                    ) : (
                                        <div className="w-full h-full flex items-center justify-center bg-primary-100 text-primary-600">
                                            <BookOpen className="h-12 w-12" />
                                        </div>
                                    )}
                                    <div className="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-md text-xs font-semibold text-primary-700 shadow-sm">
                                        {course.ma_lop}
                                    </div>
                                </div>
                                <CardContent className="p-5">
                                    <div className="mb-4">
                                        <h3 className="text-lg font-bold text-gray-900 line-clamp-1 group-hover:text-primary-600 transition-colors">
                                            {course.ten_khoa_hoc}
                                        </h3>
                                        <div className="flex items-center gap-2 mt-2 text-sm text-gray-500">
                                            <User className="h-4 w-4" />
                                            <span>{course.giang_vien}</span>
                                        </div>
                                    </div>

                                    <div className="space-y-3">
                                        <div className="flex justify-between text-sm">
                                            <span className="text-gray-500">Tiến độ</span>
                                            <span className="font-medium text-primary-600">{course.tien_do}%</span>
                                        </div>
                                        <div className="h-2 bg-gray-100 rounded-full overflow-hidden">
                                            <div
                                                className="h-full bg-primary-500 rounded-full transition-all duration-500"
                                                style={{ width: `${course.tien_do}%` }}
                                            ></div>
                                        </div>
                                    </div>

                                    <div className="mt-6 flex items-center justify-between">
                                        <div className="flex -space-x-2">
                                            {[1, 2, 3].map((i) => (
                                                <div key={i} className="h-8 w-8 rounded-full bg-gray-200 border-2 border-white flex items-center justify-center text-xs font-medium text-gray-500">
                                                    SV
                                                </div>
                                            ))}
                                            <div className="h-8 w-8 rounded-full bg-gray-100 border-2 border-white flex items-center justify-center text-xs font-medium text-gray-500">
                                                +20
                                            </div>
                                        </div>
                                        <Link to={`/student/courses/${course.id}`}>
                                            <Button size="sm" className="group-hover:bg-primary-700">
                                                Vào học
                                                <ArrowRight className="ml-2 h-4 w-4" />
                                            </Button>
                                        </Link>
                                    </div>
                                </CardContent>
                            </Card>
                        ))}
                    </div>
                ) : (
                    <div className="text-center py-12 bg-white rounded-lg border border-dashed border-gray-300">
                        <BookOpen className="h-12 w-12 text-gray-300 mx-auto mb-4" />
                        <h3 className="text-lg font-medium text-gray-900">Chưa có khóa học nào</h3>
                        <p className="text-gray-500 mt-1">Bạn chưa đăng ký khóa học nào hoặc không tìm thấy kết quả phù hợp.</p>
                    </div>
                )}
            </div>
        </DashboardLayout>
    );
}
