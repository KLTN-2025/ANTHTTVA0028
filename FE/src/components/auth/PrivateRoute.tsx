import { Navigate, useLocation } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';
import { Loader2 } from 'lucide-react';

interface PrivateRouteProps {
    children: React.ReactNode;
    allowedRoles?: ('student' | 'instructor')[];
}

export default function PrivateRoute({ children, allowedRoles }: PrivateRouteProps) {
    const { user, isAuthenticated, isLoading } = useAuth();
    const location = useLocation();

    if (isLoading) {
        return (
            <div className="min-h-screen flex items-center justify-center bg-gray-50">
                <Loader2 className="h-8 w-8 animate-spin text-primary-600" />
            </div>
        );
    }

    if (!isAuthenticated) {
        return <Navigate to="/login" state={{ from: location }} replace />;
    }

    if (allowedRoles && user && !allowedRoles.includes(user.role)) {
        // Redirect to appropriate dashboard if role doesn't match
        if (user.role === 'student') {
            return <Navigate to="/student/dashboard" replace />;
        } else {
            return <Navigate to="/instructor/dashboard" replace />;
        }
    }

    return <>{children}</>;
}
