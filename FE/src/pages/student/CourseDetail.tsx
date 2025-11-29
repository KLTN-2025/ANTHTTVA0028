import { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import { Button } from '../../components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '../../components/ui/card';
import { PlayCircle, CheckCircle, Clock, ChevronLeft, BookOpen, User, FileText, HelpCircle } from 'lucide-react';
import api from '../../services/api';
import { Loader2 } from 'lucide-react';
import { DashboardLayout } from '../../components/layout/DashboardLayout';

export default function CourseDetail() {
    const { id } = useParams();
    const [course, setCourse] = useState<any>(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchCourseDetail = async () => {
            try {
                const response = await api.get(`/student/courses/${id}`);
                setCourse(response.data);
            } catch (error) {
                console.error("Failed to fetch course detail", error);
            } finally {
                setLoading(false);
            }
        };
        fetchCourseDetail();
    }, [id]);

    if (loading) {
        return (
            <DashboardLayout role="student">
                <div className="flex justify-center items-center h-96">
                    <Loader2 className="h-8 w-8 animate-spin text-primary-600" />
                </div>
            </DashboardLayout>
        );
    }

    if (!course) {
        return (
            <DashboardLayout role="student">
                <div className="text-center py-12">Không tìm thấy khóa học.</div>
            </DashboardLayout>
        );
    }

    return (
        <DashboardLayout role="student">
            <div className="space-y-6">
                {/* Header */}
                <div className="flex flex-col md:flex-row justify-between items-start gap-4">
                    <div>
                        <Link to="/student/courses" className="inline-flex items-center text-sm text-gray-500 hover:text-primary-600 mb-2">
                            <ChevronLeft className="h-4 w-4 mr-1" />
                            Quay lại danh sách
                        </Link>
                        <h1 className="text-3xl font-bold text-gray-900">{course.ten_khoa_hoc}</h1>
                        <div className="flex items-center gap-4 mt-2 text-gray-500">
                            <span className="flex items-center gap-1">
                                <BookOpen className="h-4 w-4" />
                                {course.ten_lop}
                            </span>
                            <span className="flex items-center gap-1">
                                <User className="h-4 w-4" />
                                {course.giang_vien}
                            </span>
                        </div>
                    </div>
                    <div className="flex gap-3">
                        <Button variant="outline">Tài liệu</Button>
                        <Button>Tiếp tục học</Button>
                    </div>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Main Content - Course Structure */}
                    <div className="lg:col-span-2 space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Nội dung khóa học</CardTitle>
                            </CardHeader>
                            <CardContent className="p-0">
                                <div className="divide-y divide-gray-100">
                                    {course.bai_giangs.map((lesson: any) => (
                                        <div key={lesson.id} className="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between group">
                                            <div className="flex items-center gap-3">
                                                <div className={`h-10 w-10 rounded-full flex items-center justify-center ${lesson.hoan_thanh ? 'bg-green-100 text-green-600' :
                                                        lesson.loai === 'bai_tap' ? 'bg-orange-100 text-orange-600' :
                                                            lesson.loai === 'quiz' ? 'bg-purple-100 text-purple-600' :
                                                                'bg-blue-100 text-blue-600'
                                                    }`}>
                                                    {lesson.hoan_thanh ? <CheckCircle className="h-5 w-5" /> :
                                                        lesson.loai === 'bai_tap' ? <FileText className="h-5 w-5" /> :
                                                            lesson.loai === 'quiz' ? <HelpCircle className="h-5 w-5" /> :
                                                                <PlayCircle className="h-5 w-5" />}
                                                </div>
                                                <div>
                                                    <h4 className={`font-medium ${lesson.hoan_thanh ? 'text-gray-900' : 'text-gray-700'}`}>
                                                        {lesson.tieu_de}
                                                    </h4>
                                                    <div className="flex items-center gap-2 text-xs text-gray-500 mt-1">
                                                        {lesson.loai === 'video' && (
                                                            <span className="flex items-center gap-1">
                                                                <Clock className="h-3 w-3" />
                                                                {Math.floor(lesson.thoi_luong / 60)} phút
                                                            </span>
                                                        )}
                                                        <span className={`capitalize px-1.5 py-0.5 rounded text-[10px] ${lesson.loai === 'bai_tap' ? 'bg-orange-100 text-orange-700' :
                                                                lesson.loai === 'quiz' ? 'bg-purple-100 text-purple-700' :
                                                                    'bg-gray-100 text-gray-600'
                                                            }`}>
                                                            {lesson.loai === 'bai_tap' ? 'Bài tập' : lesson.loai === 'quiz' ? 'Quiz' : 'Video'}
                                                        </span>

                                                        {lesson.bai_tap && (
                                                            <>
                                                                {lesson.bai_tap.da_nop ? (
                                                                    <span className={`px-1.5 py-0.5 rounded text-[10px] ${lesson.bai_tap.trang_thai === 'da_cham' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'
                                                                        }`}>
                                                                        {lesson.bai_tap.trang_thai === 'da_cham' ? `Đã chấm: ${lesson.bai_tap.diem_so}đ` : 'Đã nộp'}
                                                                    </span>
                                                                ) : (
                                                                    <span className="px-1.5 py-0.5 rounded text-[10px] bg-red-100 text-red-700">
                                                                        Chưa nộp
                                                                    </span>
                                                                )}
                                                            </>
                                                        )}
                                                    </div>
                                                </div>
                                            </div>
                                            <Button variant="ghost" size="sm" className="opacity-0 group-hover:opacity-100 transition-opacity">
                                                {lesson.loai === 'bai_tap' ? 'Chi tiết' : 'Vào học'}
                                            </Button>
                                        </div>
                                    ))}
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                    {/* Sidebar - Course Info */}
                    <div className="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Thông tin chung</CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-4">
                                <div>
                                    <h4 className="text-sm font-medium text-gray-500 mb-1">Mô tả</h4>
                                    <p className="text-sm text-gray-700 leading-relaxed">
                                        {course.mo_ta}
                                    </p>
                                </div>
                                <div className="pt-4 border-t border-gray-100">
                                    <h4 className="text-sm font-medium text-gray-500 mb-2">Tiến độ học tập</h4>
                                    <div className="flex items-center justify-between text-sm mb-1">
                                        <span className="text-gray-700">Đã hoàn thành</span>
                                        <span className="font-bold text-primary-600">0%</span>
                                    </div>
                                    <div className="h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div className="h-full bg-primary-500 w-0"></div>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </DashboardLayout>
    );
}
