<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal - 학습 플랫폼</title>
    <!--tailwind CSS 사용 -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;700;900&display=swap');
        
        * {
            font-family: 'Noto Sans KR', sans-serif;
        }
        
        .card {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card:hover {
            transform: scale(1.05);
        }
        
        .card img {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card:hover img {
            transform: scale(1.05);
        }
        
        .arrow {
            transition: all 0.3s ease;
        }
        
        .card:hover .arrow {
            transform: translateX(8px);
        }
    </style>
</head>
<body class="bg-white min-h-screen">


    <!-- Hero Section -->
    <div class="container mx-auto px-6 py-20 text-center">
        <h1 class="text-6xl font-bold text-slate-900 mb-6">
            당신의 여정을 시작하세요
        </h1>
        <p class="text-xl text-slate-600 max-w-2xl mx-auto mb-16">
            원하는 교육을 선택해주세요
        </p>

        <!-- Navigation Cards -->
        <div class="grid md:grid-cols-3 gap-8 max-w-7xl mx-auto">
            
            <!-- 국비지원캠프 Card -->
            <a href="/nation-support" class="card group relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-50 to-blue-100 shadow-md border-2 border-blue-200 hover:border-blue-400 hover:shadow-xl hover:shadow-blue-300/50 block">
                <div class="aspect-[4/5] relative">
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-600/80 via-blue-500/40 to-transparent z-10"></div>
                    <img
                        src="https://images.unsplash.com/photo-1758270704384-9df36d94a29d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxlZHVjYXRpb24lMjBjbGFzc3Jvb20lMjBzdHVkZW50c3xlbnwxfHx8fDE3NjI3NDQ3ODZ8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
                        alt="국비지원캠프"
                        class="w-full h-full object-cover"
                    />
                    
                    <div class="absolute inset-0 z-20 flex flex-col justify-between p-8">
                        <div class="flex justify-start">
                            <div class="w-14 h-14 rounded-2xl bg-white backdrop-blur-sm border-2 border-blue-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="text-left">
                            <h3 class="text-3xl font-bold text-white mb-3 drop-shadow-lg">
                                국비지원캠프
                            </h3>
                            <p class="text-white mb-6 drop-shadow-md">
                                정부 지원으로 무료 교육 기회
                            </p>
                            <div class="flex items-center gap-2 text-white drop-shadow-md">
                                <span class="font-medium">시작하기</span>
                                <svg class="w-5 h-5 arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- 추천 강의 Card -->
            <a href="/video-lecture" class="card group relative overflow-hidden rounded-3xl bg-gradient-to-br from-purple-50 to-purple-100 shadow-md border-2 border-purple-200 hover:border-purple-400 hover:shadow-xl hover:shadow-purple-300/50 block">
                <div class="aspect-[4/5] relative">
                    <div class="absolute inset-0 bg-gradient-to-t from-purple-600/80 via-purple-500/40 to-transparent z-10"></div>
                    <img
                        src="https://images.unsplash.com/photo-1762330918491-f4288a62adb8?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxvbmxpbmUlMjBjb3Vyc2UlMjBsZWFybmluZ3xlbnwxfHx8fDE3NjI3NTc2MTJ8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
                        alt="추천 강의"
                        class="w-full h-full object-cover"
                    />
                    
                    <div class="absolute inset-0 z-20 flex flex-col justify-between p-8">
                        <div class="flex justify-start">
                            <div class="w-14 h-14 rounded-2xl bg-white backdrop-blur-sm border-2 border-purple-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="text-left">
                            <h3 class="text-3xl font-bold text-white mb-3 drop-shadow-lg">
                                추천 강의
                            </h3>
                            <p class="text-white mb-6 drop-shadow-md">
                                전문가가 추천하는 온라인 강의
                            </p>
                            <div class="flex items-center gap-2 text-white drop-shadow-md">
                                <span class="font-medium">시작하기</span>
                                <svg class="w-5 h-5 arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- 추천 도서 Card -->
            <a href="/book" class="card group relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-50 to-emerald-100 shadow-md border-2 border-emerald-200 hover:border-emerald-400 hover:shadow-xl hover:shadow-emerald-300/50 block">
                <div class="aspect-[4/5] relative">
                    <div class="absolute inset-0 bg-gradient-to-t from-emerald-600/80 via-emerald-500/40 to-transparent z-10"></div>
                    <img
                        src="https://images.unsplash.com/photo-1709159057219-80439fbeddce?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxib29rcyUyMGxpYnJhcnklMjByZWFkaW5nfGVufDF8fHx8MTc2MjY3Mjk0MXww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
                        alt="추천 도서"
                        class="w-full h-full object-cover"
                    />
                    
                    <div class="absolute inset-0 z-20 flex flex-col justify-between p-8">
                        <div class="flex justify-start">
                            <div class="w-14 h-14 rounded-2xl bg-white backdrop-blur-sm border-2 border-emerald-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="text-left">
                            <h3 class="text-3xl font-bold text-white mb-3 drop-shadow-lg">
                                추천 도서
                            </h3>
                            <p class="text-white mb-6 drop-shadow-md">
                                성장을 위한 필독 도서 목록
                            </p>
                            <div class="flex items-center gap-2 text-white drop-shadow-md">
                                <span class="font-medium">시작하기</span>
                                <svg class="w-5 h-5 arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

        </div>
    </div>

</body>
</html>
