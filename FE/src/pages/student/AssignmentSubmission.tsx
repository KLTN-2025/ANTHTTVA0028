import { useState } from 'react';
import { DashboardLayout } from '../../components/layout/DashboardLayout';
import { Card, CardContent, CardHeader, CardTitle } from '../../components/ui/card';
import { Button } from '../../components/ui/button';
import { UploadCloud, File, X } from 'lucide-react';
import Swal from 'sweetalert2';

export default function AssignmentSubmission() {
    const [file, setFile] = useState<File | null>(null);

    const handleFileChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        const selectedFile = event.target.files?.[0];
        if (selectedFile) {
            setFile(selectedFile);
        }
    };

    const handleRemoveFile = () => {
        setFile(null);
    };

    const handleSubmit = () => {
        if (!file) {
            Swal.fire({
                title: 'Chưa chọn file!',
                text: 'Vui lòng tải lên bài làm trước khi nộp.',
                icon: 'error',
                confirmButtonColor: '#f97316'
            });
            return;
        }

        Swal.fire({
            title: 'Xác nhận nộp bài?',
            text: "Bạn có chắc chắn muốn nộp bài tập này không?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#f97316',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Nộp bài',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                // Simulate API call
                setTimeout(() => {
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Bài tập của bạn đã được nộp thành công.',
                        icon: 'success',
                        confirmButtonColor: '#f97316'
                    }).then(() => {
                        window.history.back();
                    });
                }, 1000);
            }
        });
    };

    return (
        <DashboardLayout role="student">
            <div className="max-w-3xl mx-auto space-y-6">
                <div>
                    <h1 className="text-2xl font-bold text-gray-900">Nộp bài tập: Xây dựng Website Bán hàng</h1>
                    <p className="text-gray-500">Môn: Lập trình Web Nâng cao • Hạn nộp: 23:59 20/12/2025</p>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>Thông tin bài tập</CardTitle>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <div className="prose max-w-none text-sm text-gray-700 bg-gray-50 p-4 rounded-lg">
                            <p>Yêu cầu:</p>
                            <ul className="list-disc pl-5">
                                <li>Xây dựng trang chủ và trang chi tiết sản phẩm</li>
                                <li>Sử dụng React và Tailwind CSS</li>
                                <li>Responsive trên Mobile và Desktop</li>
                                <li>Nộp source code lên Github và gửi link kèm báo cáo PDF</li>
                            </ul>
                        </div>

                        <div className="border-t border-gray-100 pt-4">
                            <h3 className="font-semibold text-gray-900 mb-4">Nộp bài làm của bạn</h3>

                            {/* Drag & Drop Area */}
                            {!file ? (
                                <label htmlFor="file-upload" className="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:bg-gray-50 transition-colors cursor-pointer block">
                                    <input id="file-upload" type="file" className="hidden" onChange={handleFileChange} />
                                    <div className="w-12 h-12 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <UploadCloud className="w-6 h-6" />
                                    </div>
                                    <p className="text-sm font-medium text-gray-900">Kéo thả file vào đây hoặc click để chọn</p>
                                    <p className="text-xs text-gray-500 mt-1">Hỗ trợ: PDF, DOCX, ZIP (Tối đa 20MB)</p>
                                </label>
                            ) : (
                                <div className="mt-4 space-y-2">
                                    <div className="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg">
                                        <div className="flex items-center gap-3">
                                            <File className="w-5 h-5 text-blue-500" />
                                            <div>
                                                <p className="text-sm font-medium text-gray-900">{file.name}</p>
                                                <p className="text-xs text-gray-500">{(file.size / (1024 * 1024)).toFixed(2)} MB</p>
                                            </div>
                                        </div>
                                        <button onClick={handleRemoveFile} className="text-gray-400 hover:text-red-500">
                                            <X className="w-4 h-4" />
                                        </button>
                                    </div>
                                </div>
                            )}

                            <div className="mt-6">
                                <label className="block text-sm font-medium text-gray-700 mb-1">Ghi chú (Tùy chọn)</label>
                                <textarea
                                    className="w-full px-3 py-2 border border-gray-300 rounded-md h-24"
                                    placeholder="Nhập ghi chú cho giảng viên..."
                                ></textarea>
                            </div>

                            <div className="mt-6 flex justify-end">
                                <Button size="lg" className="w-full sm:w-auto" onClick={handleSubmit}>Nộp bài</Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </DashboardLayout>
    );
}
