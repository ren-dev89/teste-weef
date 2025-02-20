export default function EventList(props) {
    return (
        <div className="flex rounded-full bg-gray-100 px-4 py-2">
            {Object.values(props).map((prop, i) => {
                if (typeof prop === "string") {
                    return (
                        <div key={i} className="max-w-5x1 w-full">
                            {prop}
                        </div>
                    );
                }
            })}
        </div>
    );
}
