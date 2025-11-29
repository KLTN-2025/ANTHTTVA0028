
import { DashboardLayout } from '../../components/layout/DashboardLayout';
import { Card, CardContent, CardHeader, CardTitle } from '../../components/ui/card';
import { Button } from '../../components/ui/button';
import { CheckCircle, XCircle, Clock, FileText, Download } from 'lucide-react';
import Swal from 'sweetalert2';

export default function GradingView() {
    const handleSaveGrade = () => {
        Swal.fire({
            title: 'Lưu điểm?',
            text: "Bạn có chắc chắn muốn lưu điểm cho sinh viên này?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#f97316',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Lưu điểm',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Đã lưu!',
                    text: 'Điểm số đã được cập nhật thành công.',
                    icon: 'success',
                    confirmButtonColor: '#f97316'
                });
            }
        });
    };

    return (
        <DashboardLayout role="instructor">
            <div className="space-y-6">
                <div className="flex justify-between items-center">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">Chấm điểm: Bài tập lớn GĐ1</h1>
                        <p className="text-gray-500">Lớp: CNTT-K15-01 • Hạn nộp: 15/12/2025</p>
                    </div>
                    <div className="flex gap-2">
                        <Button variant="outline">Xuất Excel</Button>
                        <Button>Công bố điểm</Button>
                    </div>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Student List */}
                    <Card className="lg:col-span-1 h-[calc(100vh-12rem)] flex flex-col">
                        <CardHeader className="pb-3">
                            <CardTitle className="text-base">Danh sách sinh viên (45)</CardTitle>
                            <input
                                type="text"
                                placeholder="Tìm sinh viên..."
                                className="w-full px-3 py-2 border border-gray-200 rounded-md text-sm mt-2"
                            />
                        </CardHeader>
                        <CardContent className="flex-1 overflow-y-auto p-0">
                            <div className="divide-y divide-gray-100">
                                {[1, 2, 3, 4, 5, 6, 7, 8].map((i) => (
                                    <div key={i} className={`p-4 hover:bg-gray-50 cursor-pointer ${i === 1 ? 'bg-primary-50' : ''}`}>
                                        <div className="flex justify-between items-start">
                                            <div>
                                                <p className={`font-medium ${i === 1 ? 'text-primary-700' : 'text-gray-900'}`}>Nguyễn Văn {String.fromCharCode(64 + i)}</p>
                                                <p className="text-xs text-gray-500">MSSV: 202500{i}</p>
                                            </div>
                                            {i < 3 ? (
                                                <CheckCircle className="w-4 h-4 text-green-500" />
                                            ) : i === 3 ? (
                                                <Clock className="w-4 h-4 text-yellow-500" />
                                            ) : (
                                                <XCircle className="w-4 h-4 text-gray-300" />
                                            )}
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>

                    {/* Grading Area */}
                    <Card className="lg:col-span-2 h-[calc(100vh-12rem)] flex flex-col">
                        <CardHeader className="border-b border-gray-100">
                            <div className="flex justify-between items-center">
                                <CardTitle>Bài làm của Nguyễn Văn A</CardTitle>
                                <span className="text-sm text-gray-500">Nộp lúc: 14:30 14/12/2025 (Sớm 1 ngày)</span>
                            </div>
                        </CardHeader>
                        <CardContent className="flex-1 overflow-y-auto p-6 space-y-6">
                            {/* Submission Content */}
                            <div className="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h4 className="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                    <FileText className="w-4 h-4" /> File đính kèm
                                </h4>
                                <div className="flex items-center justify-between bg-white p-3 rounded border border-gray-200">
                                    <div className="flex items-center gap-3">
                                        <div className="h-10 w-10 bg-red-100 text-red-600 rounded flex items-center justify-center font-bold text-xs">PDF</div>
                                        <div>
                                            <p className="text-sm font-medium">Bao_cao_BTL_Nhom1.pdf</p>
                                            <p className="text-xs text-gray-500">2.5 MB</p>
                                        </div>
                                    </div>
                                    <Button variant="ghost" size="icon">
                                        <Download className="w-4 h-4" />
                                    </Button>
                                </div>

                                <h4 className="font-semibold text-gray-900 mt-4 mb-2">Ghi chú của sinh viên:</h4>
                                <p className="text-sm text-gray-600 italic">"Em chào thầy, đây là bài tập nhóm em ạ. Mong thầy xem xét."</p>
                            </div>

                            {/* Grading Form */}
                            <div className="space-y-4">
                                <h3 className="font-bold text-gray-900">Đánh giá</h3>

                                <div className="grid grid-cols-2 gap-4">
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-1">Điểm số (0-10)</label>
                                        <input type="number" className="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="VD: 8.5" />
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                                        <select className="w-full px-3 py-2 border border-gray-300 rounded-md">
                                            <option>Đạt</option>
                                            <option>Cần sửa lại</option>
                                            <option>Không đạt</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">Nhận xét</label>
                                    <textarea
                                        className="w-full px-3 py-2 border border-gray-300 rounded-md h-32"
                                        placeholder="Nhập nhận xét chi tiết..."
                                    ></textarea>
                                </div>

                                <div className="flex justify-end gap-3">
                                    <Button variant="outline">Lưu nháp</Button>
                                    <Button onClick={handleSaveGrade}>Lưu & Gửi điểm</Button>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </DashboardLayout>
    );
}
