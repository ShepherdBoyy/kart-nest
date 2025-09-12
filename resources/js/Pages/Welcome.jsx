import { Head, Link } from '@inertiajs/react';
import Signin from './Auth/Signin';

export default function Welcome({ user }) {
    return (
        <>
            <Signin />
        </>
    );
}