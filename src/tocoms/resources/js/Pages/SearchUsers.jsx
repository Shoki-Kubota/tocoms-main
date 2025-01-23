import PrimaryButton from '@/Components/PrimaryButton';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import InputError from '@/Components/InputError';
import { Head, usePage, } from '@inertiajs/react';
import { useRef, useState, useEffect } from 'react';
import TextareaInput from '@/Components/TextareaInput';
import NavLink from '@/Components/NavLink';
import UserCard from '@/Components/UserCard';

export default function SearchUsers({ others }) {
    const user = usePage().props.auth.user;

    useEffect(() => {
            console.log(others);
        }, []);

    return (
        <AuthenticatedLayout
            header={
                <div className="flex">
                    <div className="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <NavLink
                            href={route('dashboard')}
                            active={route().current('dashboard')}
                        >
                            地域で探す
                        </NavLink>
                    </div>
                    <div className="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <NavLink
                            href={route('posts.create')}
                            active={route().current('posts.create')}
                        >
                            趣味で探す
                        </NavLink>
                    </div>
                </div>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                {others.map((other) => (
                    <UserCard other={other} />
                ))}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
