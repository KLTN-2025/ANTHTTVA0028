import { useState } from 'react';
import Swal from 'sweetalert2';
import { DashboardLayout } from '../../components/layout/DashboardLayout';
import { Card, CardContent } from '../../components/ui/card';
import { Button } from '../../components/ui/button';
import { Clock, CheckCircle, AlertCircle } from 'lucide-react';

export default function QuizTaking() {
    const [currentQuestion, setCurrentQuestion] = useState(0);
    const [answers, setAnswers] = useState<Record<number, number>>({});
    const [isSubmitted, setIsSubmitted] = useState(false);

    const questions = [
        {
            id: 1,
            text: 'React là gì?',
            options: [
                'Một ngôn ngữ lập trình',
                'Một thư viện JavaScript để xây dựng giao diện người dùng',
                'Một Framework CSS',
                'Một hệ quản trị cơ sở dữ liệu'
            ],
            correct: 1
        },
        {
            id: 2,
            text: 'Hook nào được sử dụng để quản lý state trong Functional Component?',
            options: [
                'useEffect',
                'useContext',
                'useState',
                'useReducer'
            ],
            correct: 2
        },
        {
            id: 3,
            text: 'JSX là viết tắt của?',
            options: [
                'JavaScript XML',
                'Java Syntax Extension',
                'JSON XML',
                'JavaScript Extension'
            ],
            correct: 0
        }
    ];

    const handleSelect = (optionIndex: number) => {
        if (isSubmitted) return;
        setAnswers(prev => ({
            ...prev,
            [currentQuestion]: optionIndex
        }));
    };

    const calculateScore = () => {
        let correctCount = 0;
        questions.forEach((q, index) => {
            if (answers[index] === q.correct) {
                correctCount++;
            }
        });
        return (correctCount / questions.length) * 10;
    };

    const handleSubmit = () => {
        Swal.fire({
            title: 'Nộp bài?',
            text: "Bạn có chắc chắn muốn nộp bài không? Hành động này không thể hoàn tác.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f97316',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Nộp ngay',
            cancelButtonText: 'Làm tiếp'
        }).then((result) => {
            if (result.isConfirmed) {
                setIsSubmitted(true);
                Swal.fire({
                    title: 'Đã nộp!',
                    text: `Bạn đã hoàn thành bài kiểm tra. Điểm số: ${calculateScore().toFixed(1)}/10`,
                    icon: 'success',
                    confirmButtonColor: '#f97316'
                });
            }
        });
    };

    return (
        <DashboardLayout role="student">
            <div className="max-w-4xl mx-auto space-y-6">
                {/* Header */}
                <div className="flex justify-between items-center bg-white p-4 rounded-lg border border-gray-200 shadow-sm sticky top-20 z-10">
                    <div>
                        <h1 className="text-xl font-bold text-gray-900">Quiz Chương 1: Tổng quan về React</h1>
                        <p className="text-sm text-gray-500">Môn: Lập trình Web Nâng cao</p>
                    </div>
                    <div className="flex items-center gap-4">
                        <div className="flex items-center gap-2 text-orange-600 font-bold bg-orange-50 px-3 py-1 rounded-full">
                            <Clock className="h-4 w-4" />
                            <span>14:30</span>
                        </div>
                        {!isSubmitted && (
                            <Button onClick={handleSubmit}>Nộp bài</Button>
                        )}
                    </div>
                </div>

                {isSubmitted && (
                    <Card className="bg-green-50 border-green-200">
                        <CardContent className="p-6 text-center">
                            <CheckCircle className="h-12 w-12 text-green-600 mx-auto mb-2" />
                            <h2 className="text-2xl font-bold text-green-800">Đã nộp bài thành công!</h2>
                            <p className="text-green-700">Điểm số của bạn: <span className="font-bold text-3xl">{calculateScore().toFixed(1)}/10</span></p>
                            <Button className="mt-4" variant="outline" onClick={() => window.history.back()}>Quay lại</Button>
                        </CardContent>
                    </Card>
                )}

                {/* Question Area */}
                <div className="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <div className="lg:col-span-3 space-y-6">
                        <Card>
                            <CardContent className="p-6">
                                <div className="flex justify-between items-start mb-4">
                                    <span className="text-sm font-medium text-gray-500">Câu hỏi {currentQuestion + 1} / {questions.length}</span>
                                    <span className="text-sm text-gray-400">1 điểm</span>
                                </div>
                                <h3 className="text-lg font-medium text-gray-900 mb-6">
                                    {questions[currentQuestion].text}
                                </h3>
                                <div className="space-y-3">
                                    {questions[currentQuestion].options.map((option, index) => {
                                        const isSelected = answers[currentQuestion] === index;
                                        const isCorrect = questions[currentQuestion].correct === index;

                                        let optionStyle = "border-gray-200 hover:bg-gray-50";
                                        if (isSubmitted) {
                                            if (isCorrect) optionStyle = "bg-green-100 border-green-500 text-green-800";
                                            else if (isSelected && !isCorrect) optionStyle = "bg-red-100 border-red-500 text-red-800";
                                        } else if (isSelected) {
                                            optionStyle = "bg-primary-50 border-primary-500 text-primary-900";
                                        }

                                        return (
                                            <div
                                                key={index}
                                                onClick={() => handleSelect(index)}
                                                className={`p-4 border rounded-lg cursor-pointer transition-all flex items-center gap-3 ${optionStyle}`}
                                            >
                                                <div className={`w-5 h-5 rounded-full border flex items-center justify-center ${isSelected ? 'border-primary-500 bg-primary-500 text-white' : 'border-gray-300'}`}>
                                                    {isSelected && <div className="w-2 h-2 bg-white rounded-full" />}
                                                </div>
                                                <span>{option}</span>
                                            </div>
                                        );
                                    })}
                                </div>
                            </CardContent>
                        </Card>

                        <div className="flex justify-between">
                            <Button
                                variant="outline"
                                onClick={() => setCurrentQuestion(prev => Math.max(0, prev - 1))}
                                disabled={currentQuestion === 0}
                            >
                                Câu trước
                            </Button>
                            <Button
                                onClick={() => setCurrentQuestion(prev => Math.min(questions.length - 1, prev + 1))}
                                disabled={currentQuestion === questions.length - 1}
                            >
                                Câu tiếp
                            </Button>
                        </div>
                    </div>

                    {/* Navigation Sidebar */}
                    <div className="space-y-4">
                        <Card>
                            <CardContent className="p-4">
                                <h4 className="font-medium text-gray-900 mb-3">Danh sách câu hỏi</h4>
                                <div className="grid grid-cols-5 gap-2">
                                    {questions.map((_, index) => (
                                        <button
                                            key={index}
                                            onClick={() => setCurrentQuestion(index)}
                                            className={`w-8 h-8 rounded text-sm font-medium flex items-center justify-center transition-colors
                            ${currentQuestion === index ? 'ring-2 ring-primary-500 ring-offset-1' : ''}
                            ${answers[index] !== undefined ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500'}
                          `}
                                        >
                                            {index + 1}
                                        </button>
                                    ))}
                                </div>
                                <div className="mt-4 space-y-2 text-xs text-gray-500">
                                    <div className="flex items-center gap-2">
                                        <div className="w-3 h-3 bg-blue-100 rounded"></div> Đã trả lời
                                    </div>
                                    <div className="flex items-center gap-2">
                                        <div className="w-3 h-3 bg-gray-100 rounded"></div> Chưa trả lời
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        <Card className="bg-orange-50 border-orange-100">
                            <CardContent className="p-4 flex items-start gap-3">
                                <AlertCircle className="w-5 h-5 text-orange-500 flex-shrink-0" />
                                <p className="text-xs text-orange-800">
                                    Lưu ý: Không thoát khỏi màn hình khi đang làm bài. Hệ thống sẽ tự động nộp bài khi hết giờ.
                                </p>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </DashboardLayout>
    );
}
