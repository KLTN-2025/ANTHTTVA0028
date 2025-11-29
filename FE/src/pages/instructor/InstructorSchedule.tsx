import { DashboardLayout } from '../../components/layout/DashboardLayout';
import { Card, CardContent, CardHeader, CardTitle } from '../../components/ui/card';
import { Button } from '../../components/ui/button';
import { ChevronLeft, ChevronRight, Calendar as CalendarIcon, Clock, MapPin, Users } from 'lucide-react';

export default function InstructorSchedule() {
    const schedule = [
        {
            day: 'Thứ 2',
            date: '20/11',
            events: [
                { id: 1, time: '07:00 - 09:00', course: 'Lập trình Web Nâng cao', class: 'CNTT-K15-01', room: 'A2-301', type: 'Lý thuyết' },
                { id: 2, time: '09:30 - 11:30', course: 'Đồ án cơ sở', class: 'CNTT-K15-02', room: 'A2-305', type: 'Thực hành' },
            ]
        },
        {
            day: 'Thứ 3',
            date: '21/11',
            events: []
        },
        {
            day: 'Thứ 4',
            date: '22/11',
            events: [
                { id: 3, time: '13:00 - 15:00', course: 'Trí tuệ nhân tạo', class: 'KHDL-K14', room: 'B1-202', type: 'Lý thuyết' },
            ]
        },
        {
            day: 'Thứ 5',
            date: '23/11',
            events: [
                { id: 4, time: '07:00 - 11:00', course: 'Lập trình Web Nâng cao', class: 'CNTT-K15-01', room: 'Lab-03', type: 'Thực hành' },
            ]
        },
        {
            day: 'Thứ 6',
            date: '24/11',
            events: []
        },
        {
            day: 'Thứ 7',
            date: '25/11',
            events: []
        }
    ];

    return (
        <DashboardLayout role="instructor">
            <div className="space-y-6">
                <div className="flex justify-between items-center">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">Lịch giảng dạy</h1>
                        <p className="text-gray-500">Tuần 15 (20/11 - 26/11/2025)</p>
                    </div>
                    <div className="flex gap-2">
                        <Button variant="outline" size="icon">
                            <ChevronLeft className="h-4 w-4" />
                        </Button>
                        <Button variant="outline">Hôm nay</Button>
                        <Button variant="outline" size="icon">
                            <ChevronRight className="h-4 w-4" />
                        </Button>
                    </div>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Calendar View */}
                    <Card className="lg:col-span-2">
                        <CardHeader className="border-b border-gray-100 pb-4">
                            <CardTitle>Thời khóa biểu tuần</CardTitle>
                        </CardHeader>
                        <CardContent className="p-0">
                            <div className="divide-y divide-gray-100">
                                {schedule.map((day, index) => (
                                    <div key={index} className="flex flex-col sm:flex-row">
                                        <div className="w-full sm:w-32 p-4 bg-gray-50 border-b sm:border-b-0 sm:border-r border-gray-100 flex sm:flex-col items-center sm:items-start justify-between sm:justify-center">
                                            <span className="font-semibold text-gray-900">{day.day}</span>
                                            <span className="text-sm text-gray-500">{day.date}</span>
                                        </div>
                                        <div className="flex-1 p-4 space-y-3">
                                            {day.events.length > 0 ? (
                                                day.events.map((event) => (
                                                    <div key={event.id} className="flex flex-col md:flex-row md:items-center gap-4 p-3 rounded-lg border border-gray-100 hover:border-primary-200 hover:bg-primary-50 transition-colors cursor-pointer group">
                                                        <div className="min-w-[120px] flex items-center gap-2 text-primary-600 font-medium">
                                                            <Clock className="h-4 w-4" />
                                                            {event.time}
                                                        </div>
                                                        <div className="flex-1">
                                                            <h4 className="font-bold text-gray-900 group-hover:text-primary-700">{event.course}</h4>
                                                            <div className="flex items-center gap-3 text-sm text-gray-500 mt-1">
                                                                <span className="flex items-center gap-1"><Users className="h-3 w-3" /> {event.class}</span>
                                                                <span className="flex items-center gap-1"><MapPin className="h-3 w-3" /> {event.room}</span>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <span className={`px-2 py-1 rounded text-xs font-medium ${event.type === 'Lý thuyết' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700'
                                                                }`}>
                                                                {event.type}
                                                            </span>
                                                        </div>
                                                    </div>
                                                ))
                                            ) : (
                                                <div className="text-sm text-gray-400 italic py-2">Không có lịch dạy</div>
                                            )}
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>

                    {/* Upcoming & Notes */}
                    <div className="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle className="text-base flex items-center gap-2">
                                    <CalendarIcon className="h-4 w-4 text-primary-600" />
                                    Sự kiện sắp tới
                                </CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-4">
                                <div className="p-3 bg-red-50 rounded-lg border border-red-100">
                                    <p className="text-sm font-bold text-red-800">Hạn nộp điểm GK</p>
                                    <p className="text-xs text-red-600 mt-1">Lớp CNTT-K15-01 • Còn 2 ngày</p>
                                </div>
                                <div className="p-3 bg-blue-50 rounded-lg border border-blue-100">
                                    <p className="text-sm font-bold text-blue-800">Họp bộ môn</p>
                                    <p className="text-xs text-blue-600 mt-1">Thứ 6, 14:00 • Phòng họp 2</p>
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle className="text-base">Ghi chú nhanh</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <textarea
                                    className="w-full p-3 border border-gray-200 rounded-lg text-sm h-32 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                    placeholder="Nhập ghi chú cá nhân..."
                                ></textarea>
                                <Button className="w-full mt-2" size="sm">Lưu ghi chú</Button>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </DashboardLayout>
    );
}
