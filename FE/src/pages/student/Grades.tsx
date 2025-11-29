import { DashboardLayout } from '../../components/layout/DashboardLayout';
import { Card, CardContent, CardHeader, CardTitle } from '../../components/ui/card';
import { TrendingUp, Award, AlertTriangle } from 'lucide-react';

export default function Grades() {
    const grades = [
        {
            id: 1,
            code: 'INT3034',
            name: 'Lập trình Web Nâng cao',
            credits: 3,
            components: [
                { name: 'Chuyên cần', weight: 10, score: 10 },
                { name: 'Bài tập', weight: 20, score: 9.0 },
                { name: 'Kiểm tra giữa kỳ', weight: 20, score: 8.5 },
                { name: 'Thi cuối kỳ', weight: 50, score: null } // Not yet graded
            ]
        },
        {
            id: 2,
            code: 'INT3011',
            name: 'Trí tuệ nhân tạo',
            credits: 3,
            components: [
                { name: 'Chuyên cần', weight: 10, score: 9.0 },
                { name: 'Bài tập', weight: 20, score: 8.0 },
                { name: 'Kiểm tra giữa kỳ', weight: 20, score: 7.5 },
                { name: 'Thi cuối kỳ', weight: 50, score: 8.0 }
            ]
        }
    ];

    const calculateGPA = (components: any[]) => {
        let totalScore = 0;
        let totalWeight = 0;

        components.forEach(comp => {
            if (comp.score !== null) {
                totalScore += comp.score * comp.weight;
                totalWeight += comp.weight;
            }
        });

        if (totalWeight === 0) return 0;
        return (totalScore / totalWeight).toFixed(1);
    };

    return (
        <DashboardLayout role="student">
            <div className="space-y-6">
                <h1 className="text-2xl font-bold text-gray-900">Kết quả học tập</h1>

                {/* GPA Summary */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <Card className="bg-gradient-to-br from-primary-500 to-primary-600 text-white border-none">
                        <CardContent className="p-6">
                            <div className="flex items-center gap-4">
                                <div className="p-3 bg-white/20 rounded-full">
                                    <TrendingUp className="h-8 w-8" />
                                </div>
                                <div>
                                    <p className="text-primary-100 text-sm">GPA Tích lũy</p>
                                    <h3 className="text-3xl font-bold">3.45</h3>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardContent className="p-6 flex items-center gap-4">
                            <div className="p-3 bg-yellow-100 text-yellow-600 rounded-full">
                                <Award className="h-8 w-8" />
                            </div>
                            <div>
                                <p className="text-gray-500 text-sm">Tín chỉ tích lũy</p>
                                <h3 className="text-2xl font-bold text-gray-900">85/130</h3>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardContent className="p-6 flex items-center gap-4">
                            <div className="p-3 bg-red-100 text-red-600 rounded-full">
                                <AlertTriangle className="h-8 w-8" />
                            </div>
                            <div>
                                <p className="text-gray-500 text-sm">Cảnh báo học vụ</p>
                                <h3 className="text-2xl font-bold text-gray-900">Không</h3>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Detailed Grades */}
                <div className="space-y-6">
                    {grades.map((subject) => (
                        <Card key={subject.id}>
                            <CardHeader className="bg-gray-50 border-b border-gray-100">
                                <div className="flex justify-between items-center">
                                    <div>
                                        <CardTitle className="text-lg">{subject.name}</CardTitle>
                                        <p className="text-sm text-gray-500">{subject.code} • {subject.credits} tín chỉ</p>
                                    </div>
                                    <div className="text-right">
                                        <p className="text-sm text-gray-500">Điểm tổng kết (tạm tính)</p>
                                        <p className="text-2xl font-bold text-primary-600">{calculateGPA(subject.components)}</p>
                                    </div>
                                </div>
                            </CardHeader>
                            <CardContent className="p-0">
                                <table className="w-full">
                                    <thead className="bg-gray-50 text-xs uppercase text-gray-500">
                                        <tr>
                                            <th className="px-6 py-3 text-left">Thành phần</th>
                                            <th className="px-6 py-3 text-center">Trọng số</th>
                                            <th className="px-6 py-3 text-center">Điểm số</th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-gray-100">
                                        {subject.components.map((comp, i) => (
                                            <tr key={i}>
                                                <td className="px-6 py-4 text-sm font-medium text-gray-900">{comp.name}</td>
                                                <td className="px-6 py-4 text-sm text-gray-500 text-center">{comp.weight}%</td>
                                                <td className="px-6 py-4 text-sm font-bold text-gray-900 text-center">
                                                    {comp.score !== null ? comp.score : <span className="text-gray-400">-</span>}
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </CardContent>
                        </Card>
                    ))}
                </div>
            </div>
        </DashboardLayout>
    );
}
