import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import StudentDashboard from './pages/student/StudentDashboard';
import MyCourses from './pages/student/MyCourses';
import CourseDetail from './pages/student/CourseDetail';
import LessonPlayer from './pages/student/LessonPlayer';
import AssignmentList from './pages/student/AssignmentList';
import AssignmentSubmission from './pages/student/AssignmentSubmission';
import Schedule from './pages/student/Schedule';
import Grades from './pages/student/Grades';
import QuizTaking from './pages/student/QuizTaking';
import InstructorDashboard from './pages/instructor/InstructorDashboard';
import ClassManagement from './pages/instructor/ClassManagement';
import GradingView from './pages/instructor/GradingView';
import StudentList from './pages/instructor/StudentList';
import InstructorSchedule from './pages/instructor/InstructorSchedule';
import { Button } from './components/ui/button';
import { GraduationCap } from 'lucide-react';

function LandingPage() {
  return (
    <div className="min-h-screen bg-gradient-to-br from-primary-50 to-white flex flex-col items-center justify-center p-4">
      <div className="text-center space-y-6 max-w-2xl">
        <div className="flex justify-center">
          <div className="h-20 w-20 bg-primary-100 rounded-full flex items-center justify-center text-primary-600">
            <GraduationCap className="h-12 w-12" />
          </div>
        </div>
        <h1 className="text-4xl font-bold text-gray-900">Chào mừng đến với AgoraLearn</h1>
        <p className="text-xl text-gray-600">
          Hệ thống quản lý học tập thông minh với công nghệ AI tiên tiến.
        </p>

        <div className="flex flex-col sm:flex-row gap-4 justify-center mt-8">
          <Link to="/login">
            <Button size="lg" className="w-full sm:w-auto text-lg h-14 px-8">
              Đăng nhập Hệ thống
            </Button>
          </Link>
        </div>

        <p className="text-sm text-gray-400 mt-8">
          Phiên bản Demo Giao diện (Hardcoded Views)
        </p>
      </div>
    </div>
  );
}

import { AuthProvider } from './context/AuthContext';
import LoginPage from './pages/auth/LoginPage';

import PrivateRoute from './components/auth/PrivateRoute';

function App() {
  return (
    <AuthProvider>
      <Router>
        <Routes>
          <Route path="/" element={<LandingPage />} />
          <Route path="/login" element={<LoginPage />} />

          {/* Student Routes */}
          <Route path="/student/*" element={
            <PrivateRoute allowedRoles={['student']}>
              <Routes>
                <Route path="dashboard" element={<StudentDashboard />} />
                <Route path="courses" element={<MyCourses />} />
                <Route path="courses/:id" element={<CourseDetail />} />
                <Route path="courses/:id/learn" element={<LessonPlayer />} />
                <Route path="schedule" element={<Schedule />} />
                <Route path="assignments" element={<AssignmentList />} />
                <Route path="assignments/:id" element={<AssignmentSubmission />} />
                <Route path="quiz/:id" element={<QuizTaking />} />
                <Route path="grades" element={<Grades />} />
              </Routes>
            </PrivateRoute>
          } />

          {/* Instructor Routes */}
          <Route path="/instructor/*" element={
            <PrivateRoute allowedRoles={['instructor']}>
              <Routes>
                <Route path="dashboard" element={<InstructorDashboard />} />
                <Route path="classes" element={<ClassManagement />} />
                <Route path="students" element={<StudentList />} />
                <Route path="schedule" element={<InstructorSchedule />} />
                <Route path="grading" element={<GradingView />} />
              </Routes>
            </PrivateRoute>
          } />
        </Routes>
      </Router>
    </AuthProvider>
  );
}

export default App;
