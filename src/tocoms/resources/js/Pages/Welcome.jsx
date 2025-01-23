import { Head, Link } from '@inertiajs/react';

export default function Welcome({ auth }) {

    return (
        <>
          <Head title="Tocoms - ようこそ" />
          <div className="flex min-h-screen items-center justify-center bg-gray-100">
            <div className="text-center">
              <h1 className="text-4xl font-bold">Tocoms</h1>
              <p className="mt-4">趣味と地域で繋がるSNS</p>
              {auth.user ? (
                <Link href={route('dashboard')} className="mt-6 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                  {auth.user.name}さんのホームへ
                </Link>
              ) : (
                <>
                  <Link href={route('login')} className="mt-6 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    ログイン
                  </Link>
                  <Link href={route('register')} className="ml-4 inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">
                    新規登録
                  </Link>
                </>
              )}
            </div>
          </div>
        </>
      );
}
