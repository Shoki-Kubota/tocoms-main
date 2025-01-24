import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, usePage, } from '@inertiajs/react';
import { useRef, useState, useEffect } from 'react';
import NavLink from '@/Components/NavLink';
import UserCard from '@/Components/UserCard';
import PrimaryButton from '@/Components/PrimaryButton';

export default function SearchUsers({ hobbies }) {
    const user = usePage().props.auth.user;

    useEffect(() => {
            console.log(hobbies);
        }, []);

    return (
        <div>
            <AuthenticatedLayout
                header={
                    <div className="flex">
                        <div className="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <NavLink
                                href={route('indexbyregion')}
                                active={route().current('indexbyregion')}
                            >
                                地域で探す
                            </NavLink>
                        </div>
                        <div className="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <NavLink
                                href={route('indexbyhobby')}
                                active={route().current('indexbyhobby')}
                            >
                                趣味で探す
                            </NavLink>
                        </div>
                    </div>
                }
            >
                <Head title="Dashboard" />

                <div className="flex items-center justify-center mt-4">           
                    <select
                        className="w-72 mr-2 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required
                    >
                    <option value="">趣味を選択してください</option>
                    {hobbies.map((hobby) => (
                        <option key={hobby.id} value={hobby.id}>
                        {hobby.name}
                        </option>
                    ))}
                    </select>
                    <PrimaryButton>検索</PrimaryButton>
                </div>
            </AuthenticatedLayout>
        </div>
    );
}
