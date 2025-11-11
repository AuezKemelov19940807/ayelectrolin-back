# ⚠️ Удаляем старый storage, чтобы не ломал симлинк
RUN rm -rf public/storage

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8000
ENTRYPOINT ["/entrypoint.sh"]