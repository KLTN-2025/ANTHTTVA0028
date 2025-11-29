import React from 'react';
import { Link, useLocation } from 'react-router-dom';
import { cn } from '../../lib/utils';
import {
    LayoutDashboard,
    BookOpen,
    Calendar,
    GraduationCap,
    Users,
    ClipboardList,
    LogOut,
    Bell
} from 'lucide-react';
import { Button } from '../ui/button';

interface SidebarItem {
    icon: React.ElementType;
    label: string;
    href: string;
}

interface DashboardLayoutProps {
    children: React.ReactNode;
    role: 'student' | 'instructor';
}

const studentItems: SidebarItem[] = [
    { icon: LayoutDashboard, label: 'Tổng quan', href: '/student/dashboard' },
    { icon: BookOpen, label: 'Khóa học của tôi', href: '/student/courses' },
    { icon: Calendar, label: 'Lịch học', href: '/student/schedule' },
    { icon: ClipboardList, label: 'Bài tập & Quiz', href: '/student/assignments' },
    { icon: GraduationCap, label: 'Kết quả học tập', href: '/student/grades' },
];

const instructorItems: SidebarItem[] = [
    { icon: LayoutDashboard, label: 'Tổng quan', href: '/instructor/dashboard' },
    { icon: BookOpen, label: 'Quản lý lớp học', href: '/instructor/classes' },
    { icon: Users, label: 'Sinh viên', href: '/instructor/students' },
    { icon: Calendar, label: 'Lịch dạy', href: '/instructor/schedule' },
    { icon: ClipboardList, label: 'Chấm điểm', href: '/instructor/grading' },
];

import { useAuth } from '../../context/AuthContext';
import { useNavigate } from 'react-router-dom';

export function DashboardLayout({ children, role }: DashboardLayoutProps) {
    const location = useLocation();
    const { user, logout } = useAuth();
    const navigate = useNavigate();
    const items = role === 'student' ? studentItems : instructorItems;

    const handleLogout = () => {
        logout();
        navigate('/login');
    };

    return (
        <div className="min-h-screen bg-gray-50 flex">
            {/* Sidebar */}
            <aside className="w-64 bg-white border-r border-gray-200 fixed h-full z-10 hidden md:flex flex-col">
                <div className="p-6 border-b border-gray-100">
                    <h1 className="text-2xl font-bold text-primary-600 flex items-center gap-2">
                        <GraduationCap className="h-8 w-8" />
                        AgoraLearn
                    </h1>
                    <p className="text-xs text-gray-500 mt-1 uppercase tracking-wider font-semibold">
                        {role === 'student' ? 'Cổng thông tin Sinh viên' : 'Cổng thông tin Giảng viên'}
                    </p>
                </div>

                <nav className="flex-1 p-4 space-y-1 overflow-y-auto">
                    {items.map((item) => {
                        const isActive = location.pathname === item.href;
                        return (
                            <Link
                                key={item.href}
                                to={item.href}
                                className={cn(
                                    "flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors",
                                    isActive
                                        ? "bg-primary-50 text-primary-700"
                                        : "text-gray-600 hover:bg-gray-50 hover:text-gray-900"
                                )}
                            >
                                <item.icon className={cn("h-5 w-5", isActive ? "text-primary-600" : "text-gray-400")} />
                                {item.label}
                            </Link>
                        );
                    })}
                </nav>

                <div className="p-4 border-t border-gray-100">
                    <Button
                        variant="ghost"
                        className="w-full justify-start text-red-600 hover:text-red-700 hover:bg-red-50"
                        onClick={handleLogout}
                    >
                        <LogOut className="mr-2 h-4 w-4" />
                        Đăng xuất
                    </Button>
                </div>
            </aside>

            {/* Main Content */}
            <main className="flex-1 md:ml-64 transition-all duration-300">
                {/* Top Header */}
                <header className="h-16 bg-white border-b border-gray-200 sticky top-0 z-20 px-6 flex items-center justify-between">
                    <div className="md:hidden">
                        {/* Mobile Menu Trigger would go here */}
                        <span className="font-bold text-primary-600">AgoraLearn</span>
                    </div>

                    <div className="flex items-center gap-4 ml-auto">
                        <Button variant="ghost" size="icon" className="relative">
                            <Bell className="h-5 w-5 text-gray-600" />
                            <span className="absolute top-2 right-2 h-2 w-2 bg-red-500 rounded-full"></span>
                        </Button>
                        <div className="flex items-center gap-3 pl-4 border-l border-gray-200">
                            <div className="text-right hidden sm:block">
                                <p className="text-sm font-medium text-gray-900">{user?.ho_ten || 'Người dùng'}</p>
                                <p className="text-xs text-gray-500">{role === 'student' ? 'Sinh viên' : 'Giảng viên'}</p>
                            </div>
                            <div className="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold overflow-hidden">
                                {user?.anh_dai_dien ? (
                                    <img src={user.anh_dai_dien} alt="Avatar" className="h-full w-full object-cover" />
                                ) : (
                                    user?.ho_ten?.split(' ').pop()?.substring(0, 2).toUpperCase() || 'U'
                                )}
                            </div>
                        </div>
                    </div>
                </header>

                <div className="p-6 max-w-7xl mx-auto">
                    {children}
                </div>
            </main>
        </div>
    );
}
