import { useState, useEffect } from "react";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import PrimaryButton from "@/Components/PrimaryButton";
import { api } from "@/bootstrap";

export default function Eventos() {
    const [name, setName] = useState("");
    const [owner, setOwner] = useState("");
    const [city, setCity] = useState("");
    const [cityState, setCityState] = useState("");
    const [address, setAddress] = useState("");
    const [number, setNumber] = useState();
    const [complement, setComplement] = useState("");
    const [phone, setPhone] = useState("");

    const createEvento = async () => {
        await api
            .post("/eventos", {
                name: name,
                owner: owner,
                city: city,
                state: cityState,
                address: address,
                number: number,
                complement: complement,
                phone: phone,
            })
            .then(() => {
                window.location.href = "/dashboard";
            })
            .catch((e) => alert(e.msg));
    };

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Criar/editar evento
                </h2>
            }
        >
            <Head title="Criar evento" />

            <div className="py-12">
                <div className="mx-auto max-w-full sm:px-4 lg:px-6">
                    <div className="p-6 bg-white shadow-sm sm:rounded-lg">
                        <div className="max-w-full">
                            <label className="block">Nome do evento</label>
                            <input
                                className="w-full"
                                onChange={(e) => setName(e.target.value)}
                            />
                        </div>

                        {/* Não implementado por razões de tempo */}
                        {/* <div>
                            <label className="block">Data do evento</label>
                            <input
                                className="w-full"
                                onChange={(e) => setDate(e.target.value)}
                            />
                        </div> */}

                        <div>
                            <label className="block">Nome do responsável</label>
                            <input
                                className="w-full"
                                onChange={(e) => setOwner(e.target.value)}
                            />
                        </div>

                        <div>
                            <label className="block">Cidade</label>
                            <input
                                className="w-full"
                                onChange={(e) => setCity(e.target.value)}
                            />
                        </div>

                        <div>
                            <label className="block">Estado</label>
                            <input
                                className="w-full"
                                onChange={(e) => setCityState(e.target.value)}
                            />
                        </div>

                        <div>
                            <label className="block">Endereço</label>
                            <input
                                className="w-full"
                                onChange={(e) => setAddress(e.target.value)}
                            />
                        </div>

                        <div>
                            <label className="block">Número</label>
                            <input
                                className="w-full"
                                onChange={(e) => setNumber(e.target.value)}
                            />
                        </div>

                        <div>
                            <label className="block">
                                Complemento (opcional)
                            </label>
                            <input
                                className="w-full"
                                onChange={(e) => setComplement(e.target.value)}
                            />
                        </div>

                        <div>
                            <label className="block">Telefone</label>
                            <input
                                className="w-full"
                                onChange={(e) => setPhone(e.target.value)}
                            />
                        </div>

                        <PrimaryButton
                            className="!block mx-auto my-5"
                            onClick={createEvento}
                        >
                            Criar
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
