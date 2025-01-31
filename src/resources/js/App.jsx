import { useState, useEffect } from "react";
import '../css/loader.css';

function Header() {
    return (
        <header className="bg-violet-600 text-gray-100 shadow-md py-3 sticky top-0">
            <div className="px-4 text-2xl font-semibold tracking-wide md:container md:mx-auto">
                Project 2
            </div>
        </header>
    );
}

function Footer() {
    return (
        <footer className="bg-gray-900 text-gray-300 text-center py-4 mt-auto">
            <div className="md:container md:mx-auto px-4">
                T. Millers, VeA, 2025
            </div>
        </footer>
    );
}

// Homepage - Loads and displays top books
function Homepage({ handleBookSelection }) {
    const [topBooks, setTopBooks] = useState([]);
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(null);

    useEffect(function () {
        async function fetchTopBooks() {
            try {
                setIsLoading(true);
                setError(null);

                const response = await fetch('http://localhost/data/get-top-books');
                if (!response.ok) {
                    throw new Error("Error while loading data. Please reload page!");
                }

                const data = await response.json();
                console.log('top books fetched', data);
                setTopBooks(data);
            } catch (error) {
                setError(error.message);
            } finally {
                setIsLoading(false);
            }
        }
        
        fetchTopBooks();
    }, []);

    return (
        <>
            {isLoading && <Loader />}
            {error && <ErrorMessage msg={error} />}
            {!isLoading && !error && (
                topBooks.map((book, index) => (
                    <TopBookView
                        book={book}
                        key={book.id}
                        index={index}
                        handleBookSelection={handleBookSelection}
                    />
                ))
            )}
        </>
    );
}

// Top Book View - Displays books on Homepage
function TopBookView({ book, index, handleBookSelection }) {
    return (
        <div className="bg-gray-100 shadow-md rounded-lg p-6 mb-10 flex flex-wrap md:flex-nowrap items-center">
            <div className={`md:w-1/2 px-6 ${index % 2 === 1 ? "md:order-2 text-right" : ""}`}>
                <h2 className="text-2xl font-semibold text-gray-900">{book.name}</h2>
                <p className="text-gray-700 mt-2 text-lg">
                    {book.description.split(" ").slice(0, 20).join(" ")}...
                </p>
                <SeeMoreBtn bookID={book.id} handleBookSelection={handleBookSelection} />
            </div>
            <div className={`md:w-1/2 flex justify-center ${index % 2 === 1 ? "md:order-1" : ""}`}>
                <img
                    src={book.image}
                    alt={book.name}
                    className="rounded-md border border-gray-300 w-1/4 md:w-1/3"
                />
            </div>
        </div>
    );
}

// See More Button
function SeeMoreBtn({ bookID, handleBookSelection }) {
    return (
        <button
            className="mt-4 inline-block rounded-full py-2 px-6 bg-blue-600 hover:bg-blue-500 text-white font-medium transition-all duration-200"
            onClick={() => handleBookSelection(bookID)}
        >
            See More
        </button>
    );
}

// Book page component- structural component that contains parts of the book page
function BookPage({ selectedBookID, handleBookSelection, handleGoingBack }) {
    return (
        <>
            <SelectedBookView
                selectedBookID={selectedBookID}
                handleGoingBack={handleGoingBack}
            />
            <RelatedBookSection
                selectedBookID={selectedBookID}
                handleBookSelection={handleBookSelection}
            />
        </>
    )
}

// Selected Book View - displays selected book details
function SelectedBookView({ selectedBookID, handleGoingBack }) {
    const [selectedBook, setSelectedBook] = useState({});
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(null);

    useEffect(function () {
        async function fetchSelectedBook() {
            try {
                setIsLoading(true);
                setError(null);
                const response = await fetch('http://localhost/data/get-book/' + selectedBookID);

                if (!response.ok) {
                    throw new Error("Error while loading data. Please reload page!");
                }

                const data = await response.json();
                setSelectedBook(data);
            } catch (error) {
                setError(error.message);
                console.log(error);
            } finally {
                setIsLoading(false);
            }
        }

        fetchSelectedBook();
    }, [selectedBookID]);

    return (
        <>
            {isLoading && <Loader />}
            {error && <ErrorMessage msg={error} />}
            {!isLoading && !error && <>
                <div className="rounded-lg flex flex-wrap md:flex-row">
                    <div className="order-2 md:order-1 md:pt-12 md:basis-1/2">
                        <h1 className="text-3xl leading-8 font-light text-neutral-900 mb-2">
                            {selectedBook.name}
                        </h1>

                        <p className="text-xl leading-7 font-light text-neutral-900 mb-2">
                            {selectedBook.author}
                        </p>

                        <p className="text-xl leading-7 font-light text-neutral-900 mb-4">
                            {selectedBook.description}
                        </p>

                        <dl className="mb-4 md:flex md:flex-wrap md:flex-row">
                            <dt className="font-bold md:basis-1/4">
                                Published
                            </dt>
                            <dd className="mb-2 md:basis-3/4">
                                {selectedBook.year}
                            </dd>
                            <dt className="font-bold md:basis-1/4">
                                Price
                            </dt>
                            <dd className="mb-2 md:basis-3/4">
                                &euro; {selectedBook.price}
                            </dd>
                            <dt className="font-bold md:basis-1/4">
                                Category
                            </dt>
                            <dd className="mb-2 md:basis-3/4">
                                {selectedBook.category}
                            </dd>
                        </dl>
                    </div>
                    <div className="order-1 md:order-2 md:pt-12 md:px-12 md:basis-1/2">
                        <img
                            src={selectedBook.image}
                            alt={selectedBook.name}
                            className="p-1 rounded-md border border-neutral-200 mx-auto" />
                    </div>
                </div>
                <div className="mb-12 flex flex-wrap">
                    <GoBackBtn handleGoingBack={handleGoingBack} />
                </div>
            </>}
        </>
    )
}

// Go Back Button
function GoBackBtn({ handleGoingBack }) {
    return (
        <button
            className="inline-block rounded-full py-2 px-4 bg-neutral-500
            hover:bg-neutral-400 text-neutral-50 cursor-pointer"
            onClick={handleGoingBack}
        >Back</button>
    )
}
    
// Related Book Section
function RelatedBookSection({ selectedBookID, handleBookSelection }) {
    const [relatedBooks, setRelatedBooks] = useState([]);
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(null);

    useEffect(function () {
        async function fetchRelatedBooks() {
            try {
                setIsLoading(true);
                setError(null);
                const response = await fetch('http://localhost/data/get-related-books/' + selectedBookID);

                if (!response.ok) {
                    throw new Error("Error while loading data. Please reload page!");
                }

                const data = await response.json();
                //console.log("related books: ", data);
                setRelatedBooks(data);
            } catch (error) {
                setError(error.message);
            } finally {
                setIsLoading(false);
            }
        }

        fetchRelatedBooks();
    }, [selectedBookID]);

    return (
        <>
            {isLoading && <Loader />}
            {error && <ErrorMessage msg={error} />}
            {!isLoading && !error && <>
                <div className="flex flex-wrap">
                    <h2 className="text-3xl leading-8 font-light text-neutral-900 mb-4">
                        Similar books
                    </h2>
                </div>
                <div className="flex flex-wrap md:flex-nowrap overflow-x-auto space-x-4">
                    {relatedBooks.map(book => (
                        <RelatedBookView
                            book={book}
                            key={book.id}
                            handleBookSelection={handleBookSelection}
                        />
                    ))}
                </div>
            </>}
        </>
    );
}


// Related Book View
function RelatedBookView({ book, handleBookSelection }) {
    return (
        <div className="rounded-lg mb-4 md:basis-1/3">
            <img
                src={ book.image }
                alt={ book.name }
                className="md:h-[400px] md:mx-auto max-md:w-2/4 max-md:mx-auto" />
            <div className="p-4">
                <h3 className="text-xl leading-7 font-light text-neutral-900 mb4">
                    { book.name }
                </h3>
                <SeeMoreBtn
                    bookID={book.id}
                    handleBookSelection={handleBookSelection}
                />
            </div>
        </div>
    )
}

// Loader and Error Message components
function Loader() {
    return (
        <div className="my-12 px-2 md:container md:mx-auto text-center clear-both">
            <span class="loader"></span>
        </div>
    )
}

function ErrorMessage({ msg }) {
    return (
        <div className="md:container md:mx-auto bg-red-300 my-8 p-2">
            <p className="text-black">{ msg }</p>
        </div>
    )
}

    
export default function App() {
    const [selectedBookID, setSelectedBookID] = useState(null);

    // function to store Book ID in state
    function handleBookSelection(bookID) {
        console.log(bookID);
        setSelectedBookID(bookID);
    }

    // function to clear Book ID from state
    function handleGoingBack() {
        setSelectedBookID(null);
    }
    
    return (
        <div className="min-h-screen flex flex-col font-sans bg-gray-50 text-gray-900">
            <Header />
            <main className="flex-grow px-6 md:container md:mx-auto mt-10">
                {
                    selectedBookID
                    ? <BookPage
                            selectedBookID={selectedBookID}
                            handleBookSelection={handleBookSelection}
                            handleGoingBack={handleGoingBack}
                    />
                    : <Homepage handleBookSelection={handleBookSelection} />
                }
            </main>
            <Footer />
        </div>
    );
}
