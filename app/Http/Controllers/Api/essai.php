// Récupérez l'utilisateur actuellement authentifié
            $user = Auth::user();

            // Vérifiez si l'utilisateur est authentifié
            if ($user) {
                $userWithPosts = User::withCount('posts')->find($user->id);
                $posts = $userWithPosts->posts;
                $totalPosts = $userWithPosts->posts_count; // Nombre total de posts de l'utilisateur
                // Retournez les sondages en tant que ressource JSON
                return response()->json([
                    'posts' => PostResource::collection($posts),
                    'total_posts' => $totalPosts,
                ]);
            } else {
                // Si l'utilisateur n'est pas authentifié, renvoyez une réponse appropriée
                return response()->json(['message' => 'Utilisateur non authentifié'], 401);
            }