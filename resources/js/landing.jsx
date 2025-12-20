import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';

const App = () => {
  const [isHovered, setIsHovered] = useState(null);
  const [transactionMembers, setTransactionMembers] = useState([]);
  const [darkMode, setDarkMode] = useState(false);

  // Toggle dark mode
  const toggleDarkMode = () => {
    setDarkMode(!darkMode);
  };

  // Fetch transaction members data
  useEffect(() => {
    const fetchTransactions = async () => {
      try {
        const response = await fetch('/api/transactions');
        const data = await response.json();
        setTransactionMembers(data);
      } catch (error) {
        console.error('Error fetching transactions:', error);
        // Fallback to mock data if API fails
        const mockData = [
          { id: 1, member_name: 'John Doe', week: 'Week 1', amount: 50000, date: '2023-01-05', status: 'Paid' },
          { id: 2, member_name: 'Jane Smith', week: 'Week 1', amount: 50000, date: '2023-01-05', status: 'Paid' },
          { id: 3, member_name: 'Bob Johnson', week: 'Week 2', amount: 50000, date: '2023-01-12', status: 'Paid' },
          { id: 4, member_name: 'Alice Williams', week: 'Week 2', amount: 50000, date: '2023-01-12', status: 'Pending' },
          { id: 5, member_name: 'Charlie Brown', week: 'Week 3', amount: 50000, date: '2023-01-19', status: 'Paid' },
        ];
        setTransactionMembers(mockData);
      }
    };

    fetchTransactions();
  }, []);

  // Dummy photos for the gallery
  const photos = [
    { id: 1, title: 'Team Collaboration', description: 'Working together for success' },
    { id: 2, title: 'Financial Management', description: 'Smart money management' },
    { id: 3, title: 'Transparency', description: 'Clear and open transactions' },
    { id: 4, title: 'Community', description: 'Building together' },
    { id: 5, title: 'Efficiency', description: 'Streamlined processes' },
    { id: 6, title: 'Security', description: 'Safe and secure transactions' },
  ];

  // Generate dummy image URLs
  const getImageUrl = (id) => `https://picsum.photos/seed/kas-kelas-${id}/600/400`;

  // Format currency
  const formatCurrency = (amount) => {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0
    }).format(amount);
  };

  return (
    <div className={`min-h-screen transition-colors duration-300 ${darkMode ? 'bg-gray-900 text-white' : 'bg-gradient-to-br from-blue-50 to-indigo-100 text-gray-800'}`}>
      {/* Navigation */}
      <nav className={`flex items-center justify-between p-6 ${darkMode ? 'bg-gray-800' : 'bg-white'} shadow-md`}>
        <div className="text-2xl font-bold text-indigo-600">TRPLA125</div>
        <div className="hidden md:flex space-x-8">
          <a href="#features" className={`${darkMode ? 'text-gray-300 hover:text-white' : 'text-gray-700 hover:text-indigo-600'} transition-colors`}>Features</a>
          <a href="#transactions" className={`${darkMode ? 'text-gray-300 hover:text-white' : 'text-gray-700 hover:text-indigo-600'} transition-colors`}>Transactions</a>
          <a href="#gallery" className={`${darkMode ? 'text-gray-300 hover:text-white' : 'text-gray-700 hover:text-indigo-600'} transition-colors`}>Gallery</a>
          <a href="#about" className={`${darkMode ? 'text-gray-300 hover:text-white' : 'text-gray-700 hover:text-indigo-600'} transition-colors`}>About</a>
        </div>
        <div className="flex items-center space-x-4">
          {/* Dark mode toggle button */}
          <button
            onClick={toggleDarkMode}
            className={`p-2 rounded-full ${darkMode ? 'bg-gray-700 text-yellow-300' : 'bg-gray-200 text-gray-700'}`}
            aria-label="Toggle dark mode"
          >
            {darkMode ? (
              <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fillRule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clipRule="evenodd" />
              </svg>
            ) : (
              <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
              </svg>
            )}
          </button>
        </div>
      </nav>

      {/* Hero Section */}
      <div className="container mx-auto px-6 py-20 text-center">
        <h1 className={`text-5xl md:text-7xl font-bold ${darkMode ? 'text-white' : 'text-gray-800'} mb-6`}>
          Manage Your <span className="text-indigo-600">Class Fund</span> Effortlessly
        </h1>
        <p className={`text-xl ${darkMode ? 'text-gray-300' : 'text-gray-600'} max-w-2xl mx-auto mb-10`}>
          Simplify class financial management with our intuitive platform. Track income, expenses, and member contributions in real-time.
        </p>
        <div className="flex flex-col sm:flex-row justify-center gap-4">
          <a
            href="/admin"
            className={`bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-full text-lg font-semibold transition-colors shadow-lg transform hover:scale-105`}
          >
            Access Admin Panel
          </a>
          <a
            href="#transactions"
            className={`border-2 border-indigo-600 text-indigo-600 hover:bg-indigo-50 px-8 py-4 rounded-full text-lg font-semibold transition-colors ${darkMode ? 'hover:bg-indigo-900' : ''}`}
          >
            View Transactions
          </a>
        </div>
      </div>

      {/* Transactions Section */}
      <div id="transactions" className="container mx-auto px-6 py-20">
        <h2 className={`text-4xl font-bold text-center ${darkMode ? 'text-white' : 'text-gray-800'} mb-16`}>Recent Transactions</h2>
        <div className={`rounded-xl shadow-lg overflow-hidden ${darkMode ? 'bg-gray-800' : 'bg-white'}`}>
          <div className="overflow-x-auto">
            <table className="min-w-full divide-y divide-gray-200">
              <thead className={darkMode ? 'bg-gray-700' : 'bg-gray-50'}>
                <tr>
                  <th scope="col" className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Member</th>
                  <th scope="col" className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Week</th>
                  <th scope="col" className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Amount</th>
                  <th scope="col" className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                  <th scope="col" className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                </tr>
              </thead>
              <tbody className={`divide-y ${darkMode ? 'divide-gray-700 bg-gray-800' : 'divide-gray-200 bg-white'}`}>
                {transactionMembers.length > 0 ? (
                  transactionMembers.map((transaction) => (
                    <tr key={transaction.id} className={darkMode ? 'hover:bg-gray-700' : 'hover:bg-gray-50'}>
                      <td className={`px-6 py-4 whitespace-nowrap ${darkMode ? 'text-white' : 'text-gray-900'}`}>{transaction.member_name}</td>
                      <td className={`px-6 py-4 whitespace-nowrap ${darkMode ? 'text-gray-300' : 'text-gray-500'}`}>{transaction.week}</td>
                      <td className={`px-6 py-4 whitespace-nowrap font-semibold ${darkMode ? 'text-green-400' : 'text-green-600'}`}>{formatCurrency(transaction.amount)}</td>
                      <td className={`px-6 py-4 whitespace-nowrap ${darkMode ? 'text-gray-300' : 'text-gray-500'}`}>{transaction.date}</td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${
                          transaction.status === 'Paid'
                            ? (darkMode ? 'bg-green-800 text-green-100' : 'bg-green-100 text-green-800')
                            : (darkMode ? 'bg-yellow-800 text-yellow-100' : 'bg-yellow-100 text-yellow-800')
                        }`}>
                          {transaction.status}
                        </span>
                      </td>
                    </tr>
                  ))
                ) : (
                  <tr>
                    <td colSpan="5" className={`px-6 py-4 text-center ${darkMode ? 'text-gray-400' : 'text-gray-500'}`}>
                      Loading transactions...
                    </td>
                  </tr>
                )}
              </tbody>
            </table>
          </div>
        </div>
      </div>

      {/* Features Section */}
      <div id="features" className="container mx-auto px-6 py-20">
        <h2 className={`text-4xl font-bold text-center ${darkMode ? 'text-white' : 'text-gray-800'} mb-16`}>Key Features</h2>
        <div className="grid grid-cols-1 md:grid-cols-3 gap-10">
          <div className={`p-8 rounded-xl shadow-lg text-center hover:shadow-xl transition-shadow ${darkMode ? 'bg-gray-800' : 'bg-white'}`}>
            <div className="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
              <svg xmlns="http://www.w3.org/2000/svg" className="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
              </svg>
            </div>
            <h3 className={`text-2xl font-semibold mb-4 ${darkMode ? 'text-white' : 'text-gray-800'}`}>Real-time Tracking</h3>
            <p className={darkMode ? 'text-gray-300' : 'text-gray-600'}>Monitor all financial transactions as they happen with live updates.</p>
          </div>

          <div className={`p-8 rounded-xl shadow-lg text-center hover:shadow-xl transition-shadow ${darkMode ? 'bg-gray-800' : 'bg-white'}`}>
            <div className="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
              <svg xmlns="http://www.w3.org/2000/svg" className="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
            </div>
            <h3 className={`text-2xl font-semibold mb-4 ${darkMode ? 'text-white' : 'text-gray-800'}`}>Secure Management</h3>
            <p className={darkMode ? 'text-gray-300' : 'text-gray-600'}>Advanced security measures to protect all financial data and transactions.</p>
          </div>

          <div className={`p-8 rounded-xl shadow-lg text-center hover:shadow-xl transition-shadow ${darkMode ? 'bg-gray-800' : 'bg-white'}`}>
            <div className="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
              <svg xmlns="http://www.w3.org/2000/svg" className="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
            </div>
            <h3 className={`text-2xl font-semibold mb-4 ${darkMode ? 'text-white' : 'text-gray-800'}`}>Detailed Reports</h3>
            <p className={darkMode ? 'text-gray-300' : 'text-gray-600'}>Comprehensive reports and analytics to understand your financial trends.</p>
          </div>
        </div>
      </div>

      {/* Gallery Section */}
      <div id="gallery" className="container mx-auto px-6 py-20">
        <h2 className={`text-4xl font-bold text-center ${darkMode ? 'text-white' : 'text-gray-800'} mb-16`}>Our Platform</h2>
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {photos.map((photo) => (
            <div
              key={photo.id}
              className="overflow-hidden rounded-xl shadow-lg transform transition-all duration-300 hover:scale-105"
              onMouseEnter={() => setIsHovered(photo.id)}
              onMouseLeave={() => setIsHovered(null)}
            >
              <div className="relative">
                <img
                  src={getImageUrl(photo.id)}
                  alt={photo.title}
                  className="w-full h-64 object-cover"
                />
                <div className={`absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6 transition-opacity ${isHovered === photo.id ? 'opacity-100' : 'opacity-0'}`}>
                  <div>
                    <h3 className="text-white text-xl font-semibold">{photo.title}</h3>
                    <p className="text-gray-200">{photo.description}</p>
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* About Section */}
      <div id="about" className={`py-20 ${darkMode ? 'bg-gray-800' : 'bg-indigo-800'} text-white`}>
        <div className="container mx-auto px-6 text-center">
          <h2 className="text-4xl font-bold mb-6">About Our Platform</h2>
          <p className="text-xl max-w-3xl mx-auto mb-10">
            Designed specifically for class financial management, our platform simplifies the complex task of tracking class funds, member contributions, and expenses. Built with transparency and ease of use in mind.
          </p>
          <a
            href="/admin"
            className={`inline-block ${darkMode ? 'bg-white text-indigo-800 hover:bg-indigo-50' : 'bg-white text-indigo-800 hover:bg-indigo-50'} px-8 py-4 rounded-full text-lg font-semibold transition-colors shadow-lg`}
          >
            Get Started Today
          </a>
        </div>
      </div>

      {/* Footer */}
      <footer className={`py-10 ${darkMode ? 'bg-gray-800' : 'bg-gray-800'} text-white`}>
        <div className="container mx-auto px-6 text-center">
          <p className="text-gray-400">© {new Date().getFullYear()} Kas Kelas. All rights reserved.</p>
          <div className="mt-4 flex justify-center space-x-6">
            <a href="#" className="text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
            <a href="#" className="text-gray-400 hover:text-white transition-colors">Terms of Service</a>
            <a
              href="/admin"
              className="text-indigo-400 hover:text-white transition-colors"
            >
              Admin Login
            </a>
          </div>
        </div>
      </footer>
    </div>
  );
};

// Render the app
const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(<App />);
