import { DashboardLayout } from '../../components/layout/DashboardLayout';
import { Card, CardContent, CardHeader, CardTitle } from '../../components/ui/card';
import { Button } from '../../components/ui/button';
import { Search, Filter, Mail, MoreHorizontal, FileText } from 'lucide-react';

export default function StudentList() {
    const students = [
        { id: '2025001', name: 'Nguyễn Văn A', class: 'CNTT-K15-01', email: 'a.nguyen@example.com', gpa: 3.6, status: 'Đang học' },
        { id: '2025002', name: 'Trần Thị B', class: 'CNTT-K15-01', email: 'b.tran@example.com', gpa: 3.8, status: 'Đang học' },
        { id: '2025003', name: 'Lê Văn C', class: 'CNTT-K15-02', email: 'c.le@example.com', gpa: 2.9, status: 'Cảnh báo' },
        { id: '2025004', name: 'Phạm Thị D', class: 'CNTT-K15-01', email: 'd.pham@example.com', gpa: 3.2, status: 'Đang học' },
        { id: '2025005', name: 'Hoàng Văn E', class: 'CNTT-K15-03', email: 'e.hoang@example.com', gpa: 3.5, status: 'Đang học' },
        { id: '2025006', name: 'Đỗ Thị F', class: 'CNTT-K15-02', email: 'f.do@example.com', gpa: 3.9, status: 'Xuất sắc' },
    ];

    return (
        <DashboardLayout role="instructor">
            <div className="space-y-6">
                <div className="flex justify-between items-center">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">Quản lý Sinh viên</h1>
                        <p className="text-gray-500">Danh sách sinh viên thuộc các lớp giảng dạy</p>
                    </div>
                    <div className="flex gap-2">
                        <Button variant="outline">Xuất Excel</Button>
                        <Button>Gửi thông báo</Button>
                    </div>
                </div>

                <Card>
                    <CardHeader className="border-b border-gray-100 pb-4">
                        <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <CardTitle className="text-lg">Danh sách sinh viên ({students.length})</CardTitle>
                            <div className="flex gap-2 w-full md:w-auto">
                                <div className="relative flex-1 md:w-64">
                                    <Search className="absolute left-2.5 top-2.5 h-4 w-4 text-gray-500" />
                                    <input
                                        type="text"
                                        placeholder="Tìm theo tên, MSSV..."
                                        className="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                                    />
                                </div>
                                <Button variant="outline" size="icon">
                                    <Filter className="h-4 w-4" />
                                </Button>
                            </div>
                        </div>
                    </CardHeader>
                    <CardContent className="p-0">
                        <div className="overflow-x-auto">
                            <table className="w-full text-sm text-left">
                                <thead className="bg-gray-50 text-gray-600 font-medium border-b border-gray-200">
                                    <tr>
                                        <th className="px-6 py-3">Sinh viên</th>
                                        <th className="px-6 py-3">Lớp hành chính</th>
                                        <th className="px-6 py-3">Liên hệ</th>
                                        <th className="px-6 py-3">GPA</th>
                                        <th className="px-6 py-3">Trạng thái</th>
                                        <th className="px-6 py-3 text-right">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-100">
                                    {students.map((student) => (
                                        <tr key={student.id} className="hover:bg-gray-50 transition-colors">
                                            <td className="px-6 py-4">
                                                <div className="flex items-center gap-3">
                                                    <div className="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-xs">
                                                        {student.name.split(' ').pop()?.substring(0, 2).toUpperCase()}
                                                    </div>
                                                    <div>
                                                        <p className="font-medium text-gray-900">{student.name}</p>
                                                        <p className="text-xs text-gray-500">MSSV: {student.id}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td className="px-6 py-4 text-gray-600">{student.class}</td>
                                            <td className="px-6 py-4">
                                                <div className="flex items-center gap-2 text-gray-600">
                                                    <Mail className="h-3 w-3" />
                                                    {student.email}
                                                </div>
                                            </td>
                                            <td className="px-6 py-4 font-medium">{student.gpa}</td>
                                            <td className="px-6 py-4">
                                                <span className={`px-2 py-1 rounded-full text-xs font-medium
                                                    ${student.status === 'Xuất sắc' ? 'bg-purple-100 text-purple-700' :
                                                        student.status === 'Cảnh báo' ? 'bg-red-100 text-red-700' :
                                                            'bg-green-100 text-green-700'}
                                                `}>
                                                    {student.status}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4 text-right">
                                                <div className="flex justify-end gap-2">
                                                    <Button variant="ghost" size="icon" className="h-8 w-8">
                                                        <FileText className="h-4 w-4 text-gray-500" />
                                                    </Button>
                                                    <Button variant="ghost" size="icon" className="h-8 w-8">
                                                        <MoreHorizontal className="h-4 w-4 text-gray-500" />
                                                    </Button>
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                        <div className="p-4 border-t border-gray-100 flex justify-center">
                            <Button variant="ghost" size="sm" className="text-gray-500">Xem thêm</Button>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </DashboardLayout>
    );
}
