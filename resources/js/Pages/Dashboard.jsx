import { useState, useEffect } from "react";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import EventList from "@/Components/EventList";
import SecondaryButton from "@/Components/SecondaryButton";
import { api } from "@/bootstrap";

export default function Eventos() {
    const [events, setEvents] = useState([]);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        const getEventos = async () => {
            setLoading(true);
            await api
                .get("/eventos")
                .then((response) => setEvents(response.data))
                .finally(() => setLoading(false));
        };

        getEventos();
    }, []);

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Eventos
                </h2>
            }
        >
            <Head title="Eventos" />

            <div className="py-12">
                <div className="mx-auto max-w-full">
                    <SecondaryButton
                        className="!block mx-auto mb-5"
                        onClick={() => {
                            window.location.href = "/create";
                        }}
                    >
                        Novo Evento
                    </SecondaryButton>
                </div>

                <div className="mx-auto max-w-full sm:px-4 lg:px-6">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="px-2 py-6 text-gray-900">
                            <EventList
                                name={"Nome"}
                                // date={"Data"}
                                owner={"Responsável"}
                                address={"Local"}
                                phone={"Telefone"}
                            />
                            {events.map((ev, i) => {
                                return (
                                    <div key={i} className="block my-5">
                                        <EventList
                                            name={ev.name}
                                            // date={ev.date}
                                            owner={ev.owner}
                                            address={`${ev.address}, ${
                                                ev.number
                                            } ${
                                                ev.complement && ev.complement
                                            } ${ev.city}/${ev.state}`}
                                            phone={ev.phone}
                                        />
                                    </div>
                                );
                            })}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
