
import { DashboardLayout } from '../../components/layout/DashboardLayout';
import { Button } from '../../components/ui/button';
import { ChevronLeft, ChevronRight, MessageSquare, ThumbsUp, Share2, Flag, PlayCircle, Lock } from 'lucide-react';

export default function LessonPlayer() {
    return (
        <DashboardLayout role="student">
            <div className="flex flex-col h-[calc(100vh-8rem)]">
                {/* Video Player Area */}
                <div className="bg-black w-full aspect-video md:h-[60vh] rounded-lg relative overflow-hidden group">
                    <div className="absolute inset-0 flex items-center justify-center">
                        <span className="text-white text-lg">Video Player Placeholder</span>
                    </div>
                    {/* Fake Controls */}
                    <div className="absolute bottom-0 left-0 right-0 h-12 bg-gradient-to-t from-black/80 to-transparent flex items-center px-4 gap-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button className="text-white hover:text-primary-400">
                            <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>
                        </button>
                        <div className="h-1 flex-1 bg-gray-600 rounded-full overflow-hidden">
                            <div className="h-full w-1/3 bg-primary-500"></div>
                        </div>
                        <span className="text-white text-xs">05:30 / 15:00</span>
                    </div>
                </div>

                {/* Lesson Info & Navigation */}
                <div className="mt-4 flex flex-col md:flex-row gap-6 h-full">
                    <div className="flex-1 space-y-4 overflow-y-auto pb-6">
                        <div className="flex justify-between items-start">
                            <div>
                                <h1 className="text-2xl font-bold text-gray-900">Bài 4: Cài đặt môi trường phát triển</h1>
                                <p className="text-gray-500">Chương 1: Kiến thức nền tảng</p>
                            </div>
                            <div className="flex gap-2">
                                <Button variant="outline" size="sm">
                                    <ChevronLeft className="w-4 h-4 mr-1" /> Bài trước
                                </Button>
                                <Button size="sm">
                                    Bài tiếp <ChevronRight className="w-4 h-4 ml-1" />
                                </Button>
                            </div>
                        </div>

                        <div className="flex gap-4 py-4 border-y border-gray-100">
                            <Button variant="ghost" size="sm" className="text-gray-600">
                                <ThumbsUp className="w-4 h-4 mr-2" /> Thích
                            </Button>
                            <Button variant="ghost" size="sm" className="text-gray-600">
                                <MessageSquare className="w-4 h-4 mr-2" /> Thảo luận (12)
                            </Button>
                            <Button variant="ghost" size="sm" className="text-gray-600">
                                <Share2 className="w-4 h-4 mr-2" /> Chia sẻ
                            </Button>
                            <Button variant="ghost" size="sm" className="ml-auto text-gray-400 hover:text-red-500">
                                <Flag className="w-4 h-4" />
                            </Button>
                        </div>

                        <div className="prose max-w-none text-gray-700">
                            <h3 className="text-lg font-semibold text-gray-900">Nội dung bài học</h3>
                            <p>Trong bài học này, chúng ta sẽ cùng nhau cài đặt các công cụ cần thiết để bắt đầu lập trình với React và Laravel.</p>
                            <ul className="list-disc pl-5 space-y-1">
                                <li>Cài đặt Node.js và NPM</li>
                                <li>Cài đặt PHP và Composer</li>
                                <li>Cài đặt VS Code và các Extension cần thiết</li>
                                <li>Khởi tạo dự án đầu tiên</li>
                            </ul>
                            <p className="mt-4">Hãy đảm bảo bạn đã tải xuống đầy đủ tài liệu đính kèm trước khi bắt đầu.</p>
                        </div>
                    </div>

                    {/* Right Sidebar: Playlist */}
                    <div className="w-full md:w-80 bg-white border border-gray-200 rounded-lg flex flex-col h-full max-h-[400px] md:max-h-none">
                        <div className="p-4 border-b border-gray-100 font-semibold text-gray-900">
                            Nội dung chương
                        </div>
                        <div className="flex-1 overflow-y-auto">
                            {[1, 2, 3, 4, 5, 6].map((i) => (
                                <div
                                    key={i}
                                    className={`p-3 border-b border-gray-50 hover:bg-gray-50 cursor-pointer flex gap-3 ${i === 4 ? 'bg-primary-50' : ''}`}
                                >
                                    <div className="mt-1">
                                        {i === 4 ? (
                                            <PlayCircle className="w-4 h-4 text-primary-600" />
                                        ) : i < 4 ? (
                                            <div className="w-4 h-4 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-[10px]">✓</div>
                                        ) : (
                                            <Lock className="w-4 h-4 text-gray-300" />
                                        )}
                                    </div>
                                    <div>
                                        <p className={`text-sm font-medium ${i === 4 ? 'text-primary-700' : 'text-gray-700'}`}>
                                            Bài {i}: Tên bài học mẫu số {i}
                                        </p>
                                        <p className="text-xs text-gray-500 mt-1">15:00</p>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </DashboardLayout>
    );
}
