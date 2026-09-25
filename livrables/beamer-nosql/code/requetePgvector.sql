CREATE EXTENSION vector;

CREATE TABLE documents (
    id        bigserial PRIMARY KEY,
    contenu   text,
    langue    text,
    embedding vector(1536)  -- dimension du modèle d'embedding
);

-- Index approximatif HNSW sur la distance cosinus
CREATE INDEX ON documents USING hnsw (embedding vector_cosine_ops);

-- Les 5 documents en français les plus proches de la question
-- (<=> : distance cosinus, $1 : embedding de la question)
SELECT id, contenu, 1 - (embedding <=> $1) AS similarite
FROM documents
WHERE langue = 'fr'
ORDER BY embedding <=> $1
LIMIT 5;
