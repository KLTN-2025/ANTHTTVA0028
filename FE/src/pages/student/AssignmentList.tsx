import { DashboardLayout } from '../../components/layout/DashboardLayout';
import { Card, CardContent } from '../../components/ui/card';
import { Button } from '../../components/ui/button';
import { FileText, Clock, AlertCircle } from 'lucide-react';
import { Link } from 'react-router-dom';

export default function AssignmentList() {
    const assignments = [
        {
            id: 1,
            title: 'Quiz Chương 1: Tổng quan về React',
            course: 'Lập trình Web Nâng cao',
            dueDate: '23:59 Hôm nay',
            status: 'pending',
            type: 'quiz',
            points: 10
        },
        {
            id: 2,
            title: 'Bài tập lớn Giai đoạn 1',
            course: 'Lập trình Web Nâng cao',
            dueDate: '15/12/2025',
            status: 'pending',
            type: 'assignment',
            points: 100
        },
        {
            id: 3,
            title: 'Lab 3: Cấu trúc dữ liệu cây',
            course: 'Cấu trúc dữ liệu',
            dueDate: '20/11/2025',
            status: 'submitted',
            type: 'assignment',
            points: 10,
            score: 9.5
        },
        {
            id: 4,
            title: 'Quiz: Mạng căn bản',
            course: 'Mạng máy tính',
            dueDate: '18/11/2025',
            status: 'late',
            type: 'quiz',
            points: 10,
            score: 0
        }
    ];

    const getStatusColor = (status: string) => {
        switch (status) {
            case 'pending': return 'bg-yellow-100 text-yellow-700';
            case 'submitted': return 'bg-green-100 text-green-700';
            case 'late': return 'bg-red-100 text-red-700';
            default: return 'bg-gray-100 text-gray-700';
        }
    };

    const getStatusText = (status: string) => {
        switch (status) {
            case 'pending': return 'Chưa nộp';
            case 'submitted': return 'Đã nộp';
            case 'late': return 'Quá hạn';
            default: return 'Không xác định';
        }
    };

    return (
        <DashboardLayout role="student">
            <div className="space-y-6">
                <div>
                    <h1 className="text-2xl font-bold text-gray-900">Bài tập & Kiểm tra</h1>
                    <p className="text-gray-500">Quản lý tất cả bài tập, quiz và dự án cần hoàn thành.</p>
                </div>

                <div className="flex gap-4 border-b border-gray-200 pb-1">
                    <button className="px-4 py-2 text-sm font-medium text-primary-600 border-b-2 border-primary-600">
                        Tất cả
                    </button>
                    <button className="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                        Chưa hoàn thành
                    </button>
                    <button className="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                        Đã hoàn thành
                    </button>
                </div>

                <div className="space-y-4">
                    {assignments.map((item) => (
                        <Card key={item.id} className="hover:shadow-md transition-shadow">
                            <CardContent className="p-6 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                <div className={`p-3 rounded-full ${item.type === 'quiz' ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600'}`}>
                                    {item.type === 'quiz' ? <Clock className="h-6 w-6" /> : <FileText className="h-6 w-6" />}
                                </div>

                                <div className="flex-1">
                                    <div className="flex items-center gap-2">
                                        <h3 className="font-bold text-gray-900">{item.title}</h3>
                                        <span className={`text-xs px-2 py-0.5 rounded-full font-medium ${getStatusColor(item.status)}`}>
                                            {getStatusText(item.status)}
                                        </span>
                                    </div>
                                    <p className="text-sm text-gray-500 mt-1">{item.course}</p>
                                    <div className="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                        <span className="flex items-center gap-1">
                                            <AlertCircle className="h-3 w-3" /> Hạn: {item.dueDate}
                                        </span>
                                        <span>•</span>
                                        <span>Điểm: {item.score !== undefined ? `${item.score}/` : ''}{item.points}</span>
                                    </div>
                                </div>

                                <div className="w-full sm:w-auto">
                                    {item.status === 'pending' ? (
                                        <Link to={item.type === 'quiz' ? `/student/quiz/${item.id}` : `/student/assignments/${item.id}`}>
                                            <Button className="w-full sm:w-auto">
                                                {item.type === 'quiz' ? 'Làm bài ngay' : 'Nộp bài'}
                                            </Button>
                                        </Link>
                                    ) : (
                                        <Button variant="outline" className="w-full sm:w-auto" disabled={item.status === 'late'}>
                                            Xem lại
                                        </Button>
                                    )}
                                </div>
                            </CardContent>
                        </Card>
                    ))}
                </div>
            </div>
        </DashboardLayout>
    );
}
