#!/usr/bin/env python3
"""
Generate a MySQL INSERT statement for the `areas` table from a text file.

Assumptions (edit if needed):
- One area per line.
- Lines starting with # are comments and are ignored.
- Blank lines are ignored.
- If a line contains a delimiter, it is treated as:  name<DELIM>description
  Default delimiter: "|"  (e.g., "Area A|Some description")

Output:
- A single multi-row INSERT statement written to stdout (or to --out file).
- Uses safe SQL escaping for backslashes and single quotes.
- Uses ON DUPLICATE KEY UPDATE to avoid failing when `name` already exists (optional flag).
"""

from __future__ import annotations

import argparse
import sys
from datetime import datetime
from pathlib import Path


def sql_escape(value: str) -> str:
    """
    Escape a string for inclusion in a single-quoted MySQL string literal.
    """
    return (
        value.replace("\\", "\\\\")
             .replace("'", "\\'")
             .replace("\x00", "\\0")
             .replace("\n", "\\n")
             .replace("\r", "\\r")
             .replace("\x1a", "\\Z")
             .replace("\t", "\\t")
    )


def parse_lines(text: str, delimiter: str) -> list[tuple[str, str | None]]:
    rows: list[tuple[str, str | None]] = []

    for raw in text.splitlines():
        line = raw.strip()
        if not line or line.startswith("#"):
            continue

        if delimiter and delimiter in line:
            name, desc = line.split(delimiter, 1)
            name = name.strip()
            desc = desc.strip()
            if not name:
                continue
            rows.append((name, desc if desc else None))
        else:
            rows.append((line, None))

    # de-dupe by name while preserving order
    seen = set()
    deduped: list[tuple[str, str | None]] = []
    for name, desc in rows:
        key = name.lower()
        if key in seen:
            continue
        seen.add(key)
        deduped.append((name, desc))
    return deduped


def build_insert_sql(
    rows: list[tuple[str, str | None]],
    table: str,
    include_timestamps: bool,
    on_duplicate_update: bool,
) -> str:
    if not rows:
        return "-- No rows found. Nothing to insert.\n"

    now = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

    columns = ["name", "description"]
    if include_timestamps:
        columns += ["created_at", "updated_at"]

    col_sql = ", ".join(f"`{c}`" for c in columns)

    values_sql_parts = []
    for name, desc in rows:
        name_sql = f"'{sql_escape(name)}'"
        desc_sql = "NULL" if desc is None else f"'{sql_escape(desc)}'"

        if include_timestamps:
            ts_sql = f"'{now}'"
            values_sql_parts.append(f"({name_sql}, {desc_sql}, {ts_sql}, {ts_sql})")
        else:
            values_sql_parts.append(f"({name_sql}, {desc_sql})")

    values_sql = ",\n  ".join(values_sql_parts)

    sql = f"INSERT INTO `{table}` ({col_sql})\nVALUES\n  {values_sql}\n"

    if on_duplicate_update:
        # Avoid insert failure if name is unique and already exists
        if include_timestamps:
            sql += "ON DUPLICATE KEY UPDATE `description`=VALUES(`description`), `updated_at`=VALUES(`updated_at`);\n"
        else:
            sql += "ON DUPLICATE KEY UPDATE `description`=VALUES(`description`);\n"
    else:
        sql += ";\n"

    return sql


def main() -> int:
    ap = argparse.ArgumentParser(description="Generate MySQL INSERT for areas from a text file.")
    ap.add_argument("file", type=Path, help="Input text file (one area per line).")
    ap.add_argument("--delimiter", default="|", help="Delimiter between name and description (default: '|').")
    ap.add_argument("--table", default="areas", help="Table name (default: areas).")
    ap.add_argument("--no-timestamps", action="store_true", help="Do not include created_at/updated_at in INSERT.")
    ap.add_argument(
        "--no-upsert",
        action="store_true",
        help="Do not add ON DUPLICATE KEY UPDATE (default is to upsert).",
    )
    ap.add_argument("--out", type=Path, default=None, help="Write SQL to this file instead of stdout.")
    args = ap.parse_args()

    text = args.file.read_text(encoding="utf-8")
    rows = parse_lines(text, args.delimiter)

    sql = build_insert_sql(
        rows=rows,
        table=args.table,
        include_timestamps=not args.no_timestamps,
        on_duplicate_update=not args.no_upsert,
    )

    if args.out:
        args.out.write_text(sql, encoding="utf-8")
    else:
        sys.stdout.write(sql)

    return 0


if __name__ == "__main__":
    raise SystemExit(main())
