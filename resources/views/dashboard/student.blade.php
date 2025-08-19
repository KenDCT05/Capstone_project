<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One:wght@400&family=Nunito:wght@400;600;700;800&display=swap');
        
        .dashboard-container {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #8B0000 0%, #DC143C 50%, #B22222 100%);
            min-height: 100vh;
            padding: 2rem;
        }

        .dashboard-title {
            font-family: 'Fredoka One', cursive;
            font-size: 3rem;
            color: #FFD700;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.5);
            text-align: center;
            margin-bottom: 0.5rem;
            animation: bounce 2s infinite;
        }

        .dashboard-subtitle {
            font-size: 1.5rem;
            color: #FFE4E1;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            margin-bottom: 3rem;
        }

        .action-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .action-btn {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 3rem;
            background: linear-gradient(145deg, #FFD700, #FFA500);
            border: none;
            border-radius: 25px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #8B0000;
            font-weight: 800;
            font-size: 1.2rem;
            min-width: 200px;
        }

        .action-btn:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            background: linear-gradient(145deg, #FFA500, #FFD700);
        }

        .action-btn svg {
            width: 4rem;
            height: 4rem;
            margin-bottom: 1rem;
            animation: wiggle 2s infinite;
        }

        .learning-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .learning-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 30px;
            padding: 3rem 2rem;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            cursor: pointer;
            transition: all 0.4s ease;
            border: 5px solid transparent;
            text-decoration: none;
            color: inherit;
            position: relative;
            overflow: hidden;
        }

        .learning-card:hover {
            transform: translateY(-15px) rotate(2deg);
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
            border-color: #FFD700;
        }

        .learning-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,215,0,0.3), transparent);
            transform: rotate(45deg);
            transition: all 0.6s ease;
            opacity: 0;
        }

        .learning-card:hover::before {
            animation: shimmer 1.5s ease-in-out;
            opacity: 1;
        }

        .card-icon {
            width: 8rem;
            height: 8rem;
            margin: 0 auto 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
        }

        .materials-icon {
            background: linear-gradient(135deg, #4A90E2, #7BB3F0);
        }

        .quiz-icon {
            background: linear-gradient(135deg, #50C878, #7FD99F);
        }

        .grades-icon {
            background: linear-gradient(135deg, #9A4DFF, #B57EDC);
        }

        .card-icon svg {
            width: 4rem;
            height: 4rem;
            color: white;
            animation: pulse 2s infinite;
        }

        .card-title {
            font-family: 'Fredoka One', cursive;
            font-size: 2.5rem;
            color: #8B0000;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .card-description {
            font-size: 1.3rem;
            color: #666;
            font-weight: 600;
        }

        /* Animations */
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-20px); }
            60% { transform: translateY(-10px); }
        }

        @keyframes wiggle {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(5deg); }
            75% { transform: rotate(-5deg); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        /* Fun floating elements */
        .floating-shape {
            position: fixed;
            pointer-events: none;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .shape-1 {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape-2 {
            top: 20%;
            right: 10%;
            animation-delay: 2s;
        }

        .shape-3 {
            bottom: 20%;
            left: 15%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(180deg); }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .dashboard-title {
                font-size: 2rem;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .learning-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .card-title {
                font-size: 2rem;
            }
        }
    </style>

    <div class="dashboard-container">
        
        <!-- Floating decorative shapes -->
        <div class="floating-shape shape-1">⭐</div>
        <div class="floating-shape shape-2">🎨</div>
        <div class="floating-shape shape-3">📚</div>

        <!-- Header Section -->
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-8">
                    <h2 class="dashboard-title">My Learning Adventure!</h2>
                    <p class="dashboard-subtitle">Ready to learn something awesome today? 🚀</p>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">

                    <a href="{{ route('student.subjects.index') }}" class="action-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                        Join My Class!
                    </a>
                </div>

                <!-- Learning Cards Grid -->
                <div class="learning-grid">
                    <!-- Learning Materials Card -->
                    <a href="{{ route('materials.student.index') }}" class="learning-card">
                        <div class="card-icon materials-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3 class="card-title">My Books!</h3>
                        <p class="card-description">Find all my cool learning stuff here! 📖</p>
                    </a>

                    <!-- Quiz Card -->
                    <a href="{{ route('student.quizzes.index') }}" class="learning-card">
                        <div class="card-icon quiz-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="card-title">Fun Quiz!</h3>
                        <p class="card-description">Play games and show what I know! 🎮</p>
                    </a>

                    <!-- Grades Card -->
                    <a href="{{ route('gradebook.student') }}" class="learning-card" >
                        <div class="card-icon grades-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h3 class="card-title">My Stars!</h3>
                        <p class="card-description">See how awesome I'm doing! ⭐</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add click sound effects and animations
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.learning-card, .action-btn');
            
            cards.forEach(card => {
                card.addEventListener('click', function(e) {
                    // Create a ripple effect
                    const ripple = document.createElement('div');
                    ripple.style.position = 'absolute';
                    ripple.style.borderRadius = '50%';
                    ripple.style.background = 'rgba(255, 215, 0, 0.6)';
                    ripple.style.transform = 'scale(0)';
                    ripple.style.animation = 'ripple 0.6s linear';
                    ripple.style.left = (e.clientX - card.offsetLeft - 25) + 'px';
                    ripple.style.top = (e.clientY - card.offsetTop - 25) + 'px';
                    ripple.style.width = '50px';
                    ripple.style.height = '50px';
                    ripple.style.pointerEvents = 'none';
                    
                    card.style.position = 'relative';
                    card.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });

        // Add ripple animation keyframes
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</x-app-layout>