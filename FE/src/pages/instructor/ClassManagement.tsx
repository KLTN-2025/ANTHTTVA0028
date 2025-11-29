
import { DashboardLayout } from '../../components/layout/DashboardLayout';
import { Card, CardContent, CardHeader, CardTitle } from '../../components/ui/card';
import { Button } from '../../components/ui/button';
import { Search, Filter, MoreVertical, Eye } from 'lucide-react';

export default function ClassManagement() {
    return (
        <DashboardLayout role="instructor">
            <div className="space-y-6">
                <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">Quản lý Lớp học</h1>
                        <p className="text-gray-500">Danh sách các lớp học đang phụ trách trong học kỳ này.</p>
                    </div>
                    <Button>+ Tạo lớp mới</Button>
                </div>

                {/* Filters */}
                <div className="flex flex-col sm:flex-row gap-4 bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                    <div className="relative flex-1">
                        <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
                        <input
                            type="text"
                            placeholder="Tìm kiếm lớp học..."
                            className="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500"
                        />
                    </div>
                    <Button variant="outline" className="flex gap-2">
                        <Filter className="h-4 w-4" /> Bộ lọc
                    </Button>
                </div>

                {/* Class List */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {[1, 2, 3, 4, 5].map((i) => (
                        <Card key={i} className="hover:shadow-md transition-shadow">
                            <CardHeader className="flex flex-row items-start justify-between space-y-0 pb-2">
                                <div>
                                    <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-2">
                                        Đang diễn ra
                                    </span>
                                    <CardTitle className="text-lg font-bold">Lập trình Web Nâng cao</CardTitle>
                                    <p className="text-sm text-gray-500 font-normal mt-1">Mã lớp: CNTT-K15-0{i}</p>
                                </div>
                                <Button variant="ghost" size="icon" className="h-8 w-8">
                                    <MoreVertical className="h-4 w-4" />
                                </Button>
                            </CardHeader>
                            <CardContent>
                                <div className="space-y-4 mt-4">
                                    <div className="flex justify-between text-sm">
                                        <span className="text-gray-500">Sĩ số:</span>
                                        <span className="font-medium">45/50</span>
                                    </div>
                                    <div className="flex justify-between text-sm">
                                        <span className="text-gray-500">Phòng học:</span>
                                        <span className="font-medium">A20{i}</span>
                                    </div>
                                    <div className="flex justify-between text-sm">
                                        <span className="text-gray-500">Lịch học:</span>
                                        <span className="font-medium">T2, T4 (09:00)</span>
                                    </div>

                                    <div className="pt-4 flex gap-2">
                                        <Button className="flex-1" variant="outline">
                                            <Eye className="h-4 w-4 mr-2" /> Chi tiết
                                        </Button>
                                        <Button className="flex-1">
                                            Điểm danh
                                        </Button>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    ))}
                </div>
            </div>
        </DashboardLayout>
    );
}
