import { useEffect, useState } from 'react';
import { DashboardLayout } from '../../components/layout/DashboardLayout';
import { Card, CardContent } from '../../components/ui/card';
import { Button } from '../../components/ui/button';
import { ChevronLeft, ChevronRight, Calendar as CalendarIcon, MapPin } from 'lucide-react';
import api from '../../services/api';
import { Loader2 } from 'lucide-react';

export default function Schedule() {
    const [currentDate, setCurrentDate] = useState(new Date());
    const [schedule, setSchedule] = useState<any[]>([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchSchedule = async () => {
            try {
                // Calculate start and end of week
                const start = new Date(currentDate);
                start.setDate(currentDate.getDate() - currentDate.getDay() + 1); // Monday
                const end = new Date(start);
                end.setDate(start.getDate() + 6); // Sunday

                const response = await api.get('/student/schedule', {
                    params: {
                        start: start.toISOString().split('T')[0],
                        end: end.toISOString().split('T')[0]
                    }
                });
                setSchedule(response.data);
            } catch (error) {
                console.error("Failed to fetch schedule", error);
            } finally {
                setLoading(false);
            }
        };
        fetchSchedule();
    }, [currentDate]);

    const nextWeek = () => {
        const next = new Date(currentDate);
        next.setDate(currentDate.getDate() + 7);
        setCurrentDate(next);
    };

    const prevWeek = () => {
        const prev = new Date(currentDate);
        prev.setDate(currentDate.getDate() - 7);
        setCurrentDate(prev);
    };

    // Group schedule by date
    const groupedSchedule = schedule.reduce((acc: any, curr: any) => {
        const date = curr.start.split('T')[0];
        if (!acc[date]) {
            acc[date] = [];
        }
        acc[date].push(curr);
        return acc;
    }, {});

    // Generate days of week
    const daysOfWeek = [];
    const startOfWeek = new Date(currentDate);
    startOfWeek.setDate(currentDate.getDate() - currentDate.getDay() + 1);

    for (let i = 0; i < 7; i++) {
        const day = new Date(startOfWeek);
        day.setDate(startOfWeek.getDate() + i);
        daysOfWeek.push(day);
    }

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
                <div className="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">Lịch học</h1>
                        <p className="text-gray-500">Xem lịch học và các sự kiện sắp tới.</p>
                    </div>
                    <div className="flex items-center gap-4 bg-white p-1 rounded-lg border border-gray-200 shadow-sm">
                        <Button variant="ghost" size="icon" onClick={prevWeek}>
                            <ChevronLeft className="h-4 w-4" />
                        </Button>
                        <div className="flex items-center gap-2 px-2 font-medium">
                            <CalendarIcon className="h-4 w-4 text-gray-500" />
                            <span>
                                {startOfWeek.toLocaleDateString('vi-VN')} - {daysOfWeek[6].toLocaleDateString('vi-VN')}
                            </span>
                        </div>
                        <Button variant="ghost" size="icon" onClick={nextWeek}>
                            <ChevronRight className="h-4 w-4" />
                        </Button>
                    </div>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-7 gap-4">
                    {daysOfWeek.map((day, index) => {
                        const dateStr = day.toISOString().split('T')[0];
                        const dayEvents = groupedSchedule[dateStr] || [];
                        const isToday = new Date().toISOString().split('T')[0] === dateStr;

                        return (
                            <div key={index} className={`flex flex-col gap-3 ${index < 5 ? 'lg:col-span-1' : 'lg:col-span-1 bg-gray-50/50'}`}>
                                <div className={`text-center p-3 rounded-t-lg border-b-2 ${isToday ? 'bg-primary-50 border-primary-500' : 'bg-white border-transparent'
                                    }`}>
                                    <p className={`text-xs font-medium uppercase ${isToday ? 'text-primary-600' : 'text-gray-500'}`}>
                                        {day.toLocaleDateString('vi-VN', { weekday: 'short' })}
                                    </p>
                                    <p className={`text-lg font-bold ${isToday ? 'text-primary-700' : 'text-gray-900'}`}>
                                        {day.getDate()}
                                    </p>
                                </div>

                                <div className="space-y-2 min-h-[200px]">
                                    {dayEvents.map((event: any) => (
                                        <Card key={event.id} className="border-l-4 border-l-primary-500 shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                                            <CardContent className="p-3">
                                                <div className="text-xs font-semibold text-primary-600 mb-1">
                                                    {new Date(event.start).toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' })}
                                                    {' - '}
                                                    {new Date(event.end).toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' })}
                                                </div>
                                                <h4 className="text-sm font-bold text-gray-900 line-clamp-2 mb-2">
                                                    {event.title}
                                                </h4>
                                                <div className="flex items-center gap-1 text-xs text-gray-500">
                                                    <MapPin className="h-3 w-3" />
                                                    {event.room}
                                                </div>
                                                <div className="mt-2 inline-block px-2 py-0.5 rounded text-[10px] bg-gray-100 text-gray-600 capitalize">
                                                    {event.type}
                                                </div>
                                            </CardContent>
                                        </Card>
                                    ))}
                                    {dayEvents.length === 0 && (
                                        <div className="h-full flex items-center justify-center text-gray-300 text-sm italic py-8">
                                            Trống
                                        </div>
                                    )}
                                </div>
                            </div>
                        );
                    })}
                </div>
            </div>
        </DashboardLayout>
    );
}
