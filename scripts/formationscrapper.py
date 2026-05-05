import pandas as pd
import re
from sqlalchemy import create_engine, text

# ===== CONFIG =====
DATABASE_URL = "mysql+pymysql://AppliSupfinder:FULBERT2026@192.168.56.70:3306/Supfinder"
engine = create_engine(DATABASE_URL)

CSV_PATH = r"C:\Users\REDLER\Downloads\fr-esr-parcoursup (1).csv"

# ===== SLUGIFY =====
def slugify(text):
    text = text.lower()
    text = re.sub(r"[^\w\s-]", "", text)
    text = re.sub(r"\s+", "-", text)
    return text.strip("-")

# ===== LOAD CSV =====
df = pd.read_csv(CSV_PATH, sep=";", encoding="utf-8")

# ===== CLEAN COLUMNS =====
df.columns = df.columns.str.strip()
df.columns = (
    df.columns
    .str.normalize('NFKD')
    .str.encode('ascii', errors='ignore')
    .str.decode('utf-8')
)

# ===== MAIN =====
def main():
    with engine.begin() as conn:

        ecole_cache = {}
        count_ecoles = 0
        count_formations = 0

        for _, row in df.iterrows():

            try:
                nom_ecole = str(row["Etablissement"]).strip()
                slug_ecole = str(row["Code UAI de l'etablissement"]).strip()
                formation_nom = str(row["Filiere de formation"]).strip()
            except KeyError:
                print("❌ Problème de colonnes")
                print(df.columns.tolist())
                return

            if not nom_ecole or not slug_ecole or not formation_nom:
                continue

            # ===== ECOLE =====
            if slug_ecole not in ecole_cache:

                result = conn.execute(
                    text("SELECT id FROM ecole WHERE slug = :slug"),
                    {"slug": slug_ecole}
                ).fetchone()

                if result:
                    ecole_id = result[0]
                else:
                    conn.execute(text("""
                        INSERT INTO ecole (nom, slug)
                        VALUES (:nom, :slug)
                    """), {
                        "nom": nom_ecole,
                        "slug": slug_ecole
                    })
                    count_ecoles += 1

                    ecole_id = conn.execute(
                        text("SELECT id FROM ecole WHERE slug = :slug"),
                        {"slug": slug_ecole}
                    ).fetchone()[0]

                ecole_cache[slug_ecole] = ecole_id

            else:
                ecole_id = ecole_cache[slug_ecole]

            # ===== FORMATION =====
            exists = conn.execute(text("""
                SELECT id FROM formation
                WHERE intitule = :intitule AND ecole_id = :ecole_id
            """), {
                "intitule": formation_nom,
                "ecole_id": ecole_id
            }).fetchone()

            if not exists:
                slug_formation = slugify(formation_nom) + f"-{ecole_id}"

                conn.execute(text("""
                    INSERT INTO formation (intitule, slug, ecole_id)
                    VALUES (:intitule, :slug, :ecole_id)
                """), {
                    "intitule": formation_nom,
                    "slug": slug_formation,
                    "ecole_id": ecole_id
                })

                count_formations += 1

        print("✅ Import terminé")
        print(f"🏫 Écoles ajoutées : {count_ecoles}")
        print(f"🎓 Formations ajoutées : {count_formations}")

# ===== RUN =====
if __name__ == "__main__":
    main()